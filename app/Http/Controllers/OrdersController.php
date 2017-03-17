<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use App\Order;
use App\Restaurant;
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
                Mail::send('emails.order_details', ['order' => $order], function ($m) use ($order) {
                    $m->to($order->user->email, $order->user->name)->subject("Your Order Details");
                });
            }
            return ['status'=>'ok'];
        }else{
            return ['status'=>'error', 'error'=>'Order not found.'];
        }
    }
}
