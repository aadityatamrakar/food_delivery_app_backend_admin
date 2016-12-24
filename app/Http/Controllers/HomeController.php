<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getBarcode()
    {
        return view('barcode');
    }

    public function customers_index()
    {
        return view('customers.index');
    }

    public function customers_view($id)
    {
        $customer = Customer::find($id);
        return view('customers.view', compact('customer'));
    }

    public function delCustomer(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);

        Customer::where("id", $request->id)->first()->delete();

        return 'ok';
    }

    public function coupon()
    {
        return view('coupon.index');
    }

    public function coupon_add()
    {
        $coupon = new Coupon();
        return view('coupon.add', compact('coupon'));
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::where('id', $id)->first();

        return view('coupon.edit', compact('coupon'));
    }

    public function post_coupon_edit($id, Request $request)
    {
        $this->validate($request, [
            "return_type"  =>  "required",
            "percent"      =>  "required",
            "max_amount"   =>  "required",
            "min_amt"      =>  "required",
            "valid_from"   =>  "required",
            "valid_till"   =>  "required",
            "times"        =>  "required",
            "new_only"     =>  "required",
        ]);

        $coupon = Coupon::where('id', $id)->first();
        $coupon->return_type    =   $request->return_type;
        $coupon->percent        =   $request->percent;
        $coupon->max_amount     =   $request->max_amount;
        $coupon->min_amt        =   $request->min_amt;
        $coupon->times          =   $request->times;
        $coupon->new_only       =   $request->new_only;
        $coupon->valid_from     =   Carbon::parse($request->valid_from);
        $coupon->valid_till     =   Carbon::parse($request->valid_till);
        $coupon->save();
        return redirect('coupon')->with(['info'=>"Coupon Saved Successfully", 'type'=>"success"]);
    }

    public function post_coupon_add(Request $request)
    {
        $this->validate($request, [
            "code"         =>  "required|unique:coupon",
            "return_type"  =>  "required",
            "percent"      =>  "required",
            "max_amount"   =>  "required",
            "min_amt"      =>  "required",
            "valid_from"   =>  "required",
            "valid_till"   =>  "required",
            "times"        =>  "required",
            "new_only"     =>  "required",
        ]);

        $data = $request->only(['code', 'return_type', 'percent', 'max_amount', 'min_amt', 'valid_from', 'valid_till', 'times', 'new_only']);
        $coupon = Coupon::create($data);
        $coupon->valid_from = Carbon::parse($request->valid_from);
        $coupon->valid_till = Carbon::parse($request->valid_till);
        $coupon->save();
        return redirect('coupon')->with(['info'=>"Coupon Generated Successfully", 'type'=>"success"]);
    }

    public function delCoupon(Request $request)
    {
        $this->validate($request, [
            'id' =>"required"
        ]);
        Coupon::where("id", $request->id)->first()->delete();
        return 'ok';
    }
}
