<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use App\Order;
use App\Restaurant;
use App\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }
    public function indexRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        $orders = $restaurant->orders->sortByDesc('created_at')->all();
        return view('orders.index', compact(['restaurant', 'orders']));
    }
    public function indexCustomer($id)
    {
        $customer = Customer::where('id', $id)->first();
        $orders = $customer->orders->sortByDesc('created_at')->all();
        return view('orders.index', compact(['customer', 'orders']));
    }
    public function view_cart($id)
    {
        $order = Order::findOrFail($id);
        $order->cart = json_decode($order->cart, true);
        $coupon = $order->coupon!=null?Coupon::find($order->coupon):null;
        $quantity=0; $items=0;
        return view('orders.view', compact(['order', 'coupon', 'qauntity', 'items']));
    }

    public function change_status($id, Request $request)
    {
        if(($order = Order::where('id', $id)->first()) != null){
            $order->status = $request->status;
            $order->save();
            if($request->status == 'PROC')
            {
                $message = '';
                $restaurant = Restaurant::find($order->restaurant_id);
                if($order->deliver == 'delivery'){
                    $message = 'Hi, Your order will be delivered in approx. '.$order->restaurant->delivery_time .' mins. To follow up on your order '.$order->id.', call the restaurant directly at '.$order->restaurant->contact_no.' / '.$order->restaurant->contact_no_2;
                }else if($order->deliver == 'pickup'){
                    $message = "Hi, Your take-away time is approx. ".$order->restaurant->pickup_time .' mins. To follow up on your order '.$order->id.', call the restaurant directly at '.$order->restaurant->contact_no.' / '.$order->restaurant->contact_no_2;
                }else{
                    $message = "Hi, Your food will be ready in approx ".$order->restaurant->dinein_time .' mins. To follow up on your order '.$order->id.', call the restaurant directly at '.$order->restaurant->contact_no.' / '.$order->restaurant->contact_no_2;
                }
                $this->SendSMS($order->user->mobile, $message);
                Mail::send('emails.order_details', ['order' => $order], function ($m) use ($order) {
                    $m->to($order->user->email, $order->user->name)->subject("Your Order Details");
                });
                $message = "You have just confirmed the order ID:".$id.'. Please Try to fullfil the order on time. TromBoy!';
                $this->SendSMS($restaurant->contact_no, $message);
            }else if($request->status == 'CMPT'){
                $c = new CouponController();
                $customer = $order->user;
                $gtotal = $order->gtotal;
                $restaurant = $order->restaurant;
                $cashback = 0;
                if($order->coupon != null) {
                    $coupon = Coupon::find($order->coupon);
                    $dis = $gtotal*($coupon->percent/100);
                    if($coupon->return_type == 'cashback')
                    {
                        if($dis > $coupon->max_amount)
                            $cashback = $coupon->max_amount;
                        else
                            $cashback = $dis;
                    }
                }
                if($cashback > 0)
                {
                    wallet::create([
                        "type"      =>  "cashback_recieved",
                        'capture'   =>  "success",
                        'mode'      =>  "system",
                        'amount'    =>  round($cashback, 0),
                        'order_id'  =>  $order->id,
                        'user_id'   =>  $customer->id,
                        'restaurant_id'=> $restaurant->id,
                    ]);
                }
            }
            return ['status'=>'ok'];
        }else{
            return ['status'=>'error', 'error'=>'Order not found.'];
        }
    }

    public function resend_details($id)
    {
        $order= Order::find($id);
        $customer = $order->user;
        $restaurant = $order->restaurant;

        $cart = json_decode($order->cart, true);
        $restaurant_message = $order->id.", Type: ".$order->deliver.", Name:".$customer->name."(".$customer->mobile.', '.$order->mobile2."), ".$order->address.", Cart: [";
        for($i=0; $i<count($cart); $i++)
            $restaurant_message .= $cart[$i]['title'].'-'.$cart[$i]['quantity'].', ';
        $restaurant_message .= "]. Remarks: ".$order->remarks;
        $res = $this->SendSMS($restaurant->contact_no.','.$restaurant->contact_no_2, $restaurant_message);
        return ['status'=>"ok", 'res'=>$res];
    }
}
