<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Restaurant;
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

        $restaurant->total_transaction = $restaurant->orders->sum('gtotal');
        $restaurant->total_comm = ($restaurant->total_transaction)*($restaurant->comm_percent/100);
        $restaurant->transaction_wo_comm = $restaurant->total_transaction - $restaurant->total_comm;
        $restaurant->total_payment = $restaurant->payments->sum('amount');
        $restaurant->outstanding= $restaurant->transaction_wo_comm-$restaurant->total_payment;
        return $restaurant;
    }
}
