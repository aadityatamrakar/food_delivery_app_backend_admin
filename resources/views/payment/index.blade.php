@extends('partials.app_nav')

@section('content')
    <h2>Payments {{ Request::has('requestedonly')?": Requested":": Completed" }}</h2>
    <hr/>
    <table class="table-bordered table" id="payment_tbl">
        <thead>
        <tr>
            <td>#</td>
            <td>Restaurant</td>
            <td>Amount</td>
            <td>Status</td>
            <td>Requested At</td>
            @if(! Request::has('requestedonly'))
                <td>Mode</td>
                <td>Transaction Details</td>
                <td>Transaction Time</td>
            @else
                <td>Action</td>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $index=>$payment)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $payment->restaurant->name }}</td>
            <td>₹ {{ $payment->amount }}</td>
            <td>{{ $payment->status }}</td>
            <td>{{ \Carbon\Carbon::parse($payment->created_at)->diffForHumans() }}</td>
            @if(! Request::has('requestedonly'))
                <td>{{ $payment->mode }}</td>
                <td>{{ $payment->transaction_details }}</td>
                <td>{{ $payment->transaction_time }}</td>
            @else
                <td>
                    <button data-toggle="modal" data-target="#paymentDone" data-id='{{ $payment->id }}' class="btn btn-xs btn-success"><i class="glyphicon glyphicon-check"></i> Done</button>
                    <button data-toggle="remove_request" data-restaurant="{{ $payment->restaurant->name }}" data-amount="{{ $payment->amount }}" data-id="{{ $payment->id }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</button>
                </td>
            @endif
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td>₹ {{ $payments->sum('amount') }}</td>
            <td colspan="2"></td>
            @if(! Request::has('requestedonly'))
                <td colspan="3"></td>
            @else
                <td></td>
            @endif
        </tr>
        </tfoot>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="paymentDone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Payment Details</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="mode">Mode</label>
                                <div class="col-md-6">
                                    <input id="payment_id" name="payment_id" type="hidden">
                                    <select id="mode" name="mode" class="form-control">
                                        <option value="">Cash</option>
                                        <option value="">Cheque</option>
                                        <option value="">NEFT/RTGS</option>
                                        <option value="">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="transaction_details">Transaction Details</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" id="transaction_details" name="transaction_details"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="transaction_time">Transaction Time</label>
                                <div class="col-md-6">
                                    <div class='input-group date' id='transaction_time_box'>
                                        <input id="transaction_time" name="transaction_time" type="text" placeholder="" class="form-control input-md" required="">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_payment()">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $(document).ready(function (){
            $('#transaction_time_box').datetimepicker();
            $("#payment_tbl").dataTable();
        });

        $('#paymentDone').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var payment_id= button.data('id');
            $('#payment_id').val(payment_id);
        });

        $('[data-toggle="remove_request"]')
            .click(function (e){
                var restaurant_name = $(this).data('restaurant');
                var id = $(this).data('id');
                var amount = $(this).data('amount');

                if(confirm('Confirm remove request of '+restaurant_name+' of amount: '+amount+' ?'))
                {
                    $.ajax({
                        url: "{{ route('payment.remove') }}",
                        type: "POST",
                        data: {"_token": "{{ csrf_token() }}", id: id}
                    }).done(function (res){
                        if(res.status == 'ok'){
                            window.location.reload();
                        }else if(res.status == 'error'){
                            alert(res.error);
                        }
                    });
                }
            });

        function save_payment(){
            var id = $("#payment_id").val();
            var mode = $("#mode option:selected").html();
            var time = $("#transaction_time").val();
            var details = $("#transaction_details").val();
            $.ajax({
                url: "{{ route('payment.save') }}",
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", id: id, details: details, mode: mode, time: time}
            }).done(function (res){
                if(res.status == 'ok'){
                    window.location.reload();
                }else if(res.status == 'error'){
                    alert(res.error);
                }
            });
        }
    </script>
@endsection