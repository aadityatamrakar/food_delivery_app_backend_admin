@extends('partials.app_nav')

@section('content')
    <h3>Wallet - Summary</h3>
    <hr>
    <table class="table table-bordered" id="wallet_tbl">
        <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Reason</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $index=>$transaction)
            <tr>
                <td>{{ $index+1 }}</td>
                <td><a href="{{ route('customers.view', ['id'=>$transaction->customer->id]) }}" >{{ $transaction->customer->mobile }}</a></td>
                <td style="text-transform: capitalize;">{{ $transaction->type }}</td>
                <td>
                    @if($transaction->type == 'added' || $transaction->type == 'cashback_recieved')
                        (+)
                    @elseif($transaction->type == 'paid_for_order' || $transaction->type == 'removed')
                        (-)
                    @endif
                    Rs. {{ $transaction->amount }}</td>
                <td>{{ $transaction->reason }}</td>
                <td>{{ $transaction->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection