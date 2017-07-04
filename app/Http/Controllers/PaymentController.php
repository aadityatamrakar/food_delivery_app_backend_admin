<?php

namespace App\Http\Controllers;

use App\Order;
use App\Payment;
use App\Restaurant;
use App\wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('requestedonly'))
            $payments = Payment::where('status', 'requested')->get();
        else
            $payments = Payment::where('status', 'done')->get();

        return view('payment.index', compact('payments'));
    }

    public function payment_request(Request $request)
    {
        $pc = new PaymentController();
        if($pc->outstanding($request->restaurant_id)->outstanding >= $request->amount){
            $payment = Payment::create([
                'restaurant_id'=>$request->restaurant_id,
                'amount'=>$request->amount,
                'status'=>"requested"
            ]);
            return ['status'=>'ok', 'payment_id'=>$payment->id];
        }else return ['status'=>'error', 'error'=>"Requested amount is greater than restaurant outstanding."];
    }

    public function payment_remove(Request $request)
    {
        if(Payment::find($request->id)->status == 'requested')
        {
            if(Payment::find($request->id)->delete()){
                return ['status'=>'ok'];
            }return ['status'=>'error', 'error'=>"Refresh and Try Again"];
        }
    }

    public function payment_save(Request $request)
    {
        $payment = Payment::find($request->id);
        $payment->status = 'done';
        $payment->mode = $request->mode;
        $payment->transaction_time = Carbon::parse($request->time);
        $payment->transaction_details = $request->details;
        $payment->save();
        return ['status'=>'ok'];
    }

    public function outstanding($id)
    {
        $restaurant = Restaurant::find($id);
        $payment = Payment::where('restaurant_id', $restaurant->id)->orderBy('created_at', 'desc')->first();
        if($payment != null)
            $orders = Order::where([['restaurant_id', $restaurant->id], ['status', 'CMPT'], ['created_at', '>', $payment->created_at]])->get();
        else
            $orders = Order::where([['restaurant_id', $restaurant->id], ['status', 'CMPT']])->get();

        $online_order_gtotal = 0;
        $cod_order_gtotal = 0;
        $other_additional_amt = $outstanding_amt = 0;
        foreach($orders as $order)
        {
            $paid = null;
            $online_paid_amt = 0;
            if(($wallet = wallet::where([['order_id', $order->id], ['type', 'paid_for_order']])->first()) !=null){
                if($wallet->amount == ($order->gtotal+$order->discount)) {
                    $paid = 'paid';
                    $online_order_gtotal += ($order->gtotal+$order->discount)-($order->packing_fee+$order->delivery_fee);
                    $other_additional_amt += ($order->packing_fee+$order->delivery_fee);
                } else {
                    $paid = 'partial';
                    $online_order_gtotal += $wallet->amount;
                    $online_paid_amt = $wallet->amount;
                }
            }

            if($paid == null){
                $cod_order_gtotal += ($order->gtotal+$order->discount)-($order->packing_fee+$order->delivery_fee);
            }else if($paid == 'partial'){
                $cod_order_gtotal += (($order->gtotal+$order->discount)-($order->packing_fee+$order->delivery_fee) - $online_paid_amt);
            }
        }

        $outstanding_amt = ((100-$restaurant->comm_percent)/100)*$online_order_gtotal;
        $outstanding_amt -= ($restaurant->comm_percent/100)*$cod_order_gtotal;

        // for adding delivery and packing fee amount in online payments to restaurant
        $outstanding_amt += $other_additional_amt;

        $restaurant->outstanding = $outstanding_amt;

        return $restaurant;
    }
}
