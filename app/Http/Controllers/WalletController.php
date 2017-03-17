<?php

namespace App\Http\Controllers;

use App\Customer;
use App\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index($customer_id)
    {
        $customer = Customer::find($customer_id);
        $bal = WalletController::balance($customer);
        return view('wallet.index', compact(['customer', 'bal']));
    }

    public function manage()
    {
        return view('wallet.manage');
    }

    public function details(Request $request)
    {
        $customer = Customer::where('mobile', $request->mobile)->first();
        if($customer == null) return ['status'=>"error", "error"=>"User not found."];
        $bal = WalletController::balance($customer);
        return ['name'=>$customer->name, 'bal'=>$bal, 'status'=>"ok"];
    }

    public function all_transaction()
    {
        return view('wallet.all_transaction');
    }

    public function update(Request $request)
    {
        if($request->clear) return redirect()->route("wallet.index");

        $this->validate($request, [
            'customer_mobile' =>"required",
            "reason"    =>  "required",
            "amount"    =>  "required",
            "action"    =>  "required"
        ]);

        $customer = Customer::where('mobile', $request->customer_mobile)->first();
        if($customer == null) return back()->withInput()->with(['type'=>"danger", "info"=>"User not found."]);
        $bal = WalletController::balance($customer);
        if($request->action == 'add')
        {
            wallet::create([
                "type"      =>  "added",
                'capture'   =>  "success",
                'mode'      =>  "system",
                'amount'    =>  $request->amount,
                'reason'    =>  $request->reason,
                'user_id'   =>  $customer->id,
            ]);

        }elseif($request->action == 'remove')
        {
            if($request->amount > $bal) return back()->withInput()->with(['type'=>"danger", "info"=>"Cannot remove amount. Not enough balance."]);
            wallet::create([
                "type"      =>  "removed",
                'capture'   =>  "success",
                'mode'      =>  "system",
                'amount'    =>  $request->amount,
                'user_id'   =>  $customer->id,
                'reason'    =>  $request->reason,
            ]);
        }

        return redirect()->route('wallet.index')->with(['type'=>"success", 'info'=>"Wallet updated successfully."]);
    }

    public static function balance($customer)
    {
        $total_added = $customer->transactions->where('type', 'added')->sum('amount');
        $total_cashback = $customer->transactions->where('type', 'cashback_recieved')->sum('amount');
        $total_removed = $customer->transactions->where('type', 'removed')->sum('amount');
        $total_paid = $customer->transactions->where('type', 'paid_for_order')->sum('amount');
        return ($total_added+$total_cashback)-($total_paid+$total_removed);
    }
}
