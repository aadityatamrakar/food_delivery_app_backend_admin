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
        $outstanding_amt = 0;
        foreach($orders as $order)
        {
            if(wallet::where([['order_id', $order->id], ['type', 'added']])->first() !=null){
                $online_order_gtotal += $order->gtotal+$order->discount;
            }else{
                $cod_order_gtotal += $order->gtotal+$order->discount;
            }
        }

        $outstanding_amt = ((100-$restaurant->comm_percent)/100)*$online_order_gtotal;
        $outstanding_amt -= ($restaurant->comm_percent/100)*$cod_order_gtotal;
        $restaurant->outstanding = $outstanding_amt;
//        $restaurant->total_transaction = $restaurant->orders->sum('gtotal');
//        $restaurant->total_comm = ($restaurant->total_transaction)*($restaurant->comm_percent/100);
//        $restaurant->transaction_wo_comm = $restaurant->total_transaction - $restaurant->total_comm;
//        $restaurant->total_payment = $restaurant->payments->sum('amount');
//        $restaurant->outstanding= $restaurant->transaction_wo_comm-$restaurant->total_payment;
        return $restaurant;
    }
}
