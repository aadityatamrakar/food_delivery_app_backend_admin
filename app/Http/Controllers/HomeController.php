<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use App\Order;
use App\Payment;
use App\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $coupon->description       =   $request->description;
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

        $data = $request->only(['code', 'return_type', 'percent', 'max_amount', 'min_amt', 'valid_from', 'valid_till', 'times', 'new_only', 'description']);
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

    public function check_bal()
    {
        $parameters = str_replace(' ','', strtolower($_POST['comments']));
        $sender = substr($_POST['sender'], 2);
        if($parameters == 'bal'){
            $restaurant = Restaurant::where('contact_no', $sender)->first();
            $pc = new PaymentController();
            $message = "Your outstanding amount is Rs. ".$pc->outstanding($restaurant->id)->outstanding;
            $requested = Payment::where([['restaurant_id', $restaurant->id], ['status', 'requested']])->get()->sum('amount');
            $message .= ', Pending requested amount: Rs. '.$requested.', which makes your total outstanding Rs. '.($pc->outstanding($restaurant->id)->outstanding+$requested);
            $this->sendSMS($sender, $message);
        }
    }

    public function request_payment()
    {
        $parameters = str_replace(' ','', strtolower($_POST['comments']));
        $sender = substr($_POST['sender'], 2);
        if($parameters == 'payout'){
            $restaurant = Restaurant::where('contact_no', $sender)->first();
            $pc = new PaymentController();
            Payment::create([
                'restaurant_id'=>$restaurant->id,
                'amount'=>$pc->outstanding($restaurant->id)->outstanding,
                'status'=>"requested"
            ]);
            $message = 'New payment request has been generated.';
            $this->sendSMS($sender, $message);
        }
    }

    public function test()
    {
        $time = 0;
        $orders = Order::where('status', 'PROC')->get();
        foreach($orders as $order){
            if($order->type == 'delivery'){
                $time = $order->restaurant->delivery_time;
            }else if($order->type == 'pickup'){
                $time = $order->restaurant->pickup_time;
            }
            if(Carbon::now()->diffInMinutes(Carbon::parse($order->created_at)) > $time){
                $order->status='CMPT';
                $order->save();
            }
        }
    }
}
