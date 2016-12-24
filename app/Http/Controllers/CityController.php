<?php

namespace App\Http\Controllers;

use App\Area;
use App\City;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CityController extends Controller
{
    public function index()
    {
        return view('city.index');
    }

    public function addCity(Request $request)
    {
        $this->validate($request, [
            'name' =>"required|unique:city|max:100"
        ]);

        $city = City::create(["name"=>$request->name]);

        return 'saved';
    }

    public function removeCity(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);

        $city = City::where("id", $request->id)->first()->delete();

        return 'ok';
    }

    public function addArea(Request $request)
    {

        $this->validate($request, [
            'city_id' =>"required|exists:city,id",
            'name' =>"required"
        ]);

        if(Area::where([["city_id",$request->city_id], ["name",$request->name]])->first() == null){
            $area = Area::create(["name"=>$request->name, "city_id"=>$request->city_id]);
            return 'saved';
        }else{
            return 'duplicate';
        }

    }

    public function viewArea(Request $request)
    {
        $this->validate($request, [
            'city_id' =>"required|exists:city,id",
        ]);

        $area = Area::select('id', 'name')->where('city_id', $request->city_id)->orderBy('name', 'asc')->get();

        return json_encode($area);
    }

    public function delArea(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);

        $area = Area::where("id", $request->id)->first()->delete();

        return 'ok';
    }

    public function editArea(Request $request)
    {
        $this->validate($request, [
            'id'        =>  "required|exists:area,id",
            "name"      =>  "required"
        ]);

        $area = Area::where("id", $request->id)->first();

        if(Area::where([["name",$request->name], ["city_id", $area->city_id]])->first() == null){
            $area->name = $request->name;
            $area->save();
            return 'ok';
        }else{
            return 'duplicate';
        }
    }
}
