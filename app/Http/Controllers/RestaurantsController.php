<?php

namespace App\Http\Controllers;

use App\Area;
use App\Category;
use App\Product;
use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantsController extends Controller
{
    public function index()
    {
        $pc = new PaymentController();
        return view('restaurants.index', compact('pc'));
    }
    public function viewRestaurants($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();

        return view('restaurants.view', compact('restaurant'));

    }
    public function getEdit($id)
    {
        $restaurant = Restaurant::where('id', $id)->first();

        return view('restaurants.edit', compact('restaurant'));

    }
    public function postEdit($id, Request $request)
    {
        $request->cuisines = json_encode($request->cuisines);

        $this->validate($request, [
            'name'              =>"required",
            'address'           =>"required",
            'city_id'           =>"required|exists:city,id",
            'pincode'           =>"required|numeric|digits:6",
            'owner_name'        =>"required",
            'contact_no'        =>"required|numeric|digits:10",
            'contact_no_2'      =>"required|numeric|digits:10",
            'telephone'         =>"numeric",
            'email'             =>"required|email",
            'type'              =>"required",
            'speciality'        =>"required",
            'comm_percent'      =>"required",
            'delivery_time'     =>"numeric",
            'pickup_time'       =>"numeric",
            'dinein_time'       =>"numeric",
            'delivery_fee'      =>"numeric",
            'min_delivery_amt'  =>"numeric",
            'packing_fee'       =>"numeric",
            'payment_modes'     =>"required",
        ]);

        $restaurant = Restaurant::where("id", $request->id)->first();
        $restaurant->name = $request->name;
        $restaurant->address = $request->address;
        $restaurant->city_id = $request->city_id;
        $restaurant->pincode = $request->pincode;
        $restaurant->owner_name = $request->owner_name;
        $restaurant->contact_no = $request->contact_no;
        $restaurant->contact_no_2 = $request->contact_no_2;
        $restaurant->telephone = $request->telephone?:null;
        $restaurant->email = $request->email;
        $restaurant->comm_percent = $request->comm_percent;
        $restaurant->speciality = $request->speciality;
        $restaurant->type = $request->type;
        $restaurant->delivery_time = $request->delivery_time?:null;
        $restaurant->pickup_time = $request->pickup_time?:null;
        $restaurant->dinein_time = $request->dinein_time?:null;
        $restaurant->delivery_fee = $request->delivery_fee?:null;
        $restaurant->min_delivery_amt = $request->min_delivery_amt?:null;
        $restaurant->packing_fee = $request->packing_fee?:null;
        $restaurant->payment_modes = $request->payment_modes;
        $restaurant->tin = $request->tin?:null;
        $restaurant->pan = $request->pan?:null;
        $restaurant->account_holder = $request->account_holder;
        $restaurant->account_no = $request->account_no;
        $restaurant->account_ifsc = $request->account_ifsc;
        $restaurant->account_bank = $request->account_bank;
        $restaurant->cuisines = $request->cuisines;

        $restaurant->save();

        if($request->file('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo')->move('images/restaurant/logo/', date('U').'.'.$request->file('logo')->clientExtension());
            $restaurant->logo = $file->getFilename();
            $restaurant->save();
        }

        return redirect()->route('restaurants')->with(["info"=>"Restaurant Updated Successfully", "type"=>"success"]);
    }
    public function getAdd()
    {
        $restaurant = new Restaurant();

        return view('restaurants.add', compact('restaurant'));
    }
    public function getDelete($id)
    {
        return view('restaurants.delete');
    }
    public function postDelete($id, Request $request)
    {
        if($request->delete == '' && ($request->confirm == 'Yes' || $request->confirm == 'yes')){
            Restaurant::where('id', $id)->first()->delete();
            return redirect()->route("restaurants")->with(["info"=>"Deleted Successfully.", "type"=>"success"]);
        }else
            return redirect()->route("restaurants")->with(["info"=>"User Canceled.", "type"=>"warning"]);
    }
    public function getTime($id)
    {
        $restaurant = Restaurant::select(['id', 'name', 'city_id', 'delivery_hours', 'pickup_hours', 'dinein_hours'])->where("id", $id)->first();

        return view('restaurants.time', compact(["restaurant", "id"]));
    }
    public function postTime($id, $time, Request $request)
    {
        if($time == 'del')
        {
            $restaurant = Restaurant::where('id', $id)->first();
            $restaurant->delivery_hours = $request->data;
            $restaurant->save();
        }else if($time == 'pkp')
        {
            $restaurant = Restaurant::where('id', $id)->first();
            $restaurant->pickup_hours = $request->data;
            $restaurant->save();
        }else if($time == 'dine')
        {
            $restaurant = Restaurant::where('id', $id)->first();
            $restaurant->dinein_hours = $request->data;
            $restaurant->save();
        }

        return 'ok';
    }
    public function getMenu($id)
    {
        $restaurant = Restaurant::select(['id', 'name'])->where('id', $id)->first();

        return view('restaurants.menu.index', compact('restaurant'));
    }
    public function postArea($id, Request $request)
    {
        $data = json_decode($request->data, true);
        $uncheck = json_decode($request->uncheck, true);
        $remove = array_diff($uncheck, $data);

        foreach($data as $area_id)
        {
            $area = Area::where('id', $area_id)->first();
            $tmp = $area->restaurant_id==''?[]:json_decode($area->restaurant_id, true);
            if(! in_array($id, $tmp)) array_push($tmp, $id);
            $area->restaurant_id = json_encode($tmp);
            $area->save();
        }

        foreach($remove as $area_id)
        {
            $area = Area::where('id', $area_id)->first();
            $tmp = $area->restaurant_id==''?[]:json_decode($area->restaurant_id, true);
            array_splice($tmp, array_search($id, $tmp), 1);
            $area->restaurant_id = json_encode($tmp);
            $area->save();
        }

        return 'ok';
    }
    public function postAdd(Request $request)
    {
        $request->cuisines = json_encode($request->cuisines);

        $this->validate($request, [
            'name'              =>  "required",
            'address'           =>  "required",
            'city_id'           =>  "required|exists:city,id",
            'pincode'           =>  "required|numeric|digits:6",
            'owner_name'        =>  "required",
            'contact_no'        =>  "required|numeric|digits:10",
            'contact_no_2'      =>  "required|numeric|digits:10",
            'telephone'         =>  "numeric",
            'email'             =>  "required|email",
            'speciality'        =>  "required",
            'comm_percent'      =>  "required",
            'type'              =>  "required",
            'delivery_time'     =>  "numeric",
            'pickup_time'       =>  "numeric",
            'dinein_time'       =>  "numeric",
            'delivery_fee'      =>  "numeric",
            'min_delivery_amt'  =>  "numeric",
            'packing_fee'       =>  "numeric",
            'payment_modes'     =>  "required",
        ]);

        $restaurant = Restaurant::create([
            'name'              =>  $request->name,
            'address'           =>  $request->address,
            'city_id'           =>  $request->city_id,
            'pincode'           =>  $request->pincode,
            'owner_name'        =>  $request->owner_name,
            'contact_no'        =>  $request->contact_no,
            'contact_no_2'      =>  $request->contact_no_2,
            'telephone'         =>  $request->telephone?:null,
            'email'             =>  $request->email,
            'speciality'        =>  $request->speciality,
            'comm_percent'      =>  $request->comm_percent,
            'cuisines'          =>  $request->cuisines,
            'type'              =>  $request->type,
            'delivery_time'     =>  $request->delivery_time?:null,
            'pickup_time'       =>  $request->pickup_time?:null,
            'dinein_time'       =>  $request->dinein_time?:null,
            'delivery_fee'      =>  $request->delivery_fee?:null,
            'min_delivery_amt'  =>  $request->min_delivery_amt?:null,
            'packing_fee'       =>  $request->packing_fee?:null,
            'payment_modes'     =>  $request->payment_modes,
            'tin'               =>  $request->tin?:null,
            'pan'               =>  $request->pan?:null,
            'account_holder'    =>  $request->account_holder,
            'account_no'        =>  $request->account_no,
            'account_bank'      =>  $request->account_bank,
            'account_ifsc'      =>  $request->account_ifsc,
        ]);

        if($request->file('logo')->isValid()) {
            $file = $request->file('logo')->move('images/restaurant/logo/', date('U').'.'.$request->file('logo')->clientExtension());
            $restaurant->logo = $file->getFilename();
            $restaurant->save();
        }

        return redirect()->route('restaurants.add')->with(["info"=>"Restaurant added Successfully", "type"=>"success"]);
    }
    public function addCategory($id)
    {
        $restaurant_id = $id;
        return view('restaurants.menu.addcategory', compact('restaurant_id'))->with('edit', false);
    }
    public function postAddCategory($id, Request $request)
    {
        $this->validate($request, [
            'title' => "required"
        ]);

        if(Restaurant::where('id', $id)->first()->categories->where('title', $request->title)->first() == null)
            Category::create(["title"=>$request->title, "restaurant_id"=>$id]);
        else
            return redirect()->route('restaurants.addCategory', ['id'=>$id])->with(['info'=>"Duplicate Category Name in Same Restaurant", 'type'=>"danger"]);

        if($request->save == 'ok' || $request->savenext == null)
            return redirect()->route('restaurants.menu', ['id'=>$id])->with(['info'=>"Successfully Added", 'type'=>"success"]);
        else
            return redirect()->route('restaurants.addCategory', ['id'=>$id])->with(['info'=>"Successfully Added", 'type'=>"success"]);
    }
    public function delCategory(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);

        Category::where("id", $request->id)->first()->delete();

        return 'ok';
    }
    public function editCategory($id, $category_id)
    {
        $restaurant_id = $id;
        $category = Category::where('id', $category_id)->first();

        return view('restaurants.menu.addcategory', compact(['restaurant_id', 'category']))->with('edit', true);
    }
    public function postEditCategory($id, $category_id, Request $request)
    {
        $this->validate($request, [
            "title"      =>  "required"
        ]);

        $category = Category::where("id", $category_id)->first();

        if(Restaurant::where('id', $id)->first()->categories->where('title', $request->title)->first() == null){
            $category->title = $request->title;
            $category->save();
            return redirect()->route('restaurants.menu', ['id'=>$id])->with(['info'=>"Successfully Edited", 'type'=>"success"]);
        }else{
            return back()->withInput()->with(['info'=>"Duplicate !!", 'type'=>"danger"]);
        }
    }
    public function getProducts($id)
    {
        return view('restaurants.menu.products', compact('id'));
    }
    public function addProduct($id)
    {
        $category_id = $id;
        return view('restaurants.menu.addproduct', compact('category_id'))->with('edit', false);
    }
    public function postAddProduct($id, Request $request)
    {
        $this->validate($request, [
            'title' =>  "required",
            'price' =>  "required"
        ]);
        $category = Category::where('id', $id)->first();
        if($category->products->where('title', $request->title)->first() == null)
            Product::create(["title"=>$request->title, 'mrp'=>$request->mrp, 'price'=>$request->price, "category_id"=>$id]);
        else
            return redirect()->route('restaurants.addProduct', ['id'=>$id])->with(['info'=>"Duplicate Product Name in Same Category", 'type'=>"danger"]);

        if($request->save == 'ok' || $request->savenext == null)
            return redirect()->route('restaurants.category', ['id'=>$id])->with(['info'=>"Successfully Added", 'type'=>"success"]);
        else
            return redirect()->route('restaurants.addProduct', ['id'=>$id])->with(['info'=>"Successfully Added", 'type'=>"success"]);
    }
    public function delProduct(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);

        Product::where("id", $request->id)->first()->delete();

        return 'ok';
    }
    public function editProduct($id, $product_id)
    {
        $category_id = $id;
        $product = Product::where('id', $product_id)->first();

        return view('restaurants.menu.addproduct', compact(['category_id', 'product']))->with('edit', true);
    }
    public function postEditProduct($id, $product_id, Request $request)
    {
        $this->validate($request, [
            "title"     =>  "required",
            'price'     =>  "required"
        ]);

        $product = Product::where("id", $product_id)->first();

        $category = Category::where('id', $id)->first();


        if(($count = count($category->products->where('title', $request->title)->all())) <= 1){
            if(($count == 1 && $category->products->where('title', $request->title)->first()->id == $product_id) || $count == 0)
            {
                $product->title = $request->title;
                $product->mrp = $request->mrp;
                $product->price = $request->price;
                $product->save();
                return redirect()->route('restaurants.category', ['id'=>$id])->with(['info'=>"Successfully Edited", 'type'=>"success"]);
            }
        }

        return back()->withInput()->with(['info'=>"Duplicate !!", 'type'=>"danger"]);
    }
}
