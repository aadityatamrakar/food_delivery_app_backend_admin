@extends('partials.app_nav')

@section('content')
    <h3>Wallet - <a href="{{ route('customers.view', ['id'=>$customer->id]) }}">{{ $customer->name }}</a>, Current Balance: Rs. {{ $bal }}</h3>

    <hr>

    <table class="table table-bordered" id="wallet_tbl">
        <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Order</th>
            <th>Restaurant</th>
            <th>Reason</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customer->transactions as $index=>$transaction)
            <tr>
                <td>{{ $index+1 }}</td>
                <td style="text-transform: capitalize;">{{ $transaction->type }}</td>
                <td>
                    @if($transaction->type == 'added' || $transaction->type == 'cashback_recieved')
                        (+)
                    @elseif($transaction->type == 'paid_for_order' || $transaction->type == 'removed')
                        (-)
                    @endif
                    Rs. {{ $transaction->amount }}</td>
                @if($transaction->order_id != null)
                    <td><a target="_blank" href="{{ route('orders.view', ["id"=>$transaction->order_id ]) }}">#{{ $transaction->order_id }}</a></td>
                @else
                    <td></td>
                @endif
                @if($transaction->restaurant_id != null)
                    <td><a target="_blank" href="{{ route('restaurants.view', ["id"=>$transaction->restaurant_id]) }}">{{ \App\Restaurant::find($transaction->restaurant_id)->name }}</a></td>
                @else
                    <td></td>
                @endif
                <td>{{ $transaction->reason }}</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection