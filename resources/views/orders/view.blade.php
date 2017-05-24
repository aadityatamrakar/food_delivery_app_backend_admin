@extends('partials.app_nav')

@section('content')
    <div class="container">
        <h3>Order Details : {{ $order->id }}, Restaurant: <a target="_blank" href="{{ route('restaurants.view', ['id'=>$order->restaurant->id]) }}">{{ $order->restaurant->name }}</a>, City: {{ $order->city }}</h3>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Order Details</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <tbody>
                            <tr>
                                <th>Order No</th>
                                <td>
                                    {{ $order->id }}
                                    <button class="btn btn-xs btn-primary" data-toggle="resend"><i class="glyphicon glyphicon-send"></i> Resend Details</button>
                                </td>
                            </tr>
                            <tr>
                                <th>Order Time</th>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Order Type</th>
                                <td style="text-transform: capitalize;">{{ $order->deliver }}</td>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td>
                                    @if($order->status == 'WFRA' || $order->status == 'PROC')
                                        <button data-toggle="modal" data-id="{{ $order->id }}" data-target="#changeStatus" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-send"></i></button>
                                    @endif
                                    <span id="order_status">{{ $order->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Packing Fee</th>
                                <td>₹ {{ $order->packing_fee }}</td>
                            </tr>
                            <tr>
                                <th>Delivery Fee</th>
                                <td>₹ {{ $order->delivery_fee }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Customer Details</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $order->user->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $order->address }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $order->city }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Coupon Details</div>
                    <div class="panel-body">
                        @if($coupon != null)
                            <table class="table table-responsive">
                                <tbody>
                                <tr>
                                    <th>Type</th>
                                    <td style="text-transform: capitalize;">{{ $coupon->return_type }}</td>
                                </tr>
                                <tr>
                                    <th>Code</th>
                                    <td>{{ $coupon->code }}</td>
                                </tr>
                                <tr>
                                    <th>Percent</th>
                                    <td>{{ $coupon->percent }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    @if($coupon->return_type == 'cashback')
                                        <td>{{ $order->transactions->where("type", 'cashback_recieved')->first()!=null?$order->transactions->where("type", 'cashback_recieved')->first()->amount:'Awaiting Confirmation' }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <p>No Coupon has been applied.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Cart Details</div>
                    <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                            <th>#</th>
                            <th>Item Name</th>
                            <th style="text-align: right;">Quantity</th>
                            <th style="text-align: right;">Amount</th>
                            </thead>
                            <tbody>
                            @foreach($order->cart as $index=>$product)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $product['title'] }}</td>
                                    <td style="text-align: right;">{{ $product['quantity'] }}</td>
                                    <td style="text-align: right;">₹ {{ $product['quantity']*$product['price'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <td style="text-align: right;">₹ {{ $order->gtotal }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Status</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="status">status</label>
                                <div class="col-md-6">
                                    <select id="status" name="status" class="form-control">
                                        <option>PROC</option>
                                        <option>CNCL</option>
                                        <option>DECL</option>
                                        <option>CMPT</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="order_id" name="order_id" />
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-toggle="changeStatus">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('[data-toggle="changeStatus"]').click(function (){
            $(this).attr('disabled', '');
            changeStatus();
        });

        function changeStatus(){
            var status = $("#status").val();
            $.ajax({
                url: "{{ route('orders.changeStatus', ['id'=>$order->id]) }}",
                type: "POST",
                data: {'_token': "{{ csrf_token() }}", status: status}
            }).done(function (res){
                if(res.status == 'ok'){
                    $("#order_status").html(status);
                    $.notify('Status changed sucessfully.', 'success');
                    $("#changeStatus").modal('hide');
                }else{
                    $.notify(res.error, 'danger');
                }
            });
        }

        $('[data-toggle="resend"]').click(function () {
            $(this).attr('disabled', '');
            $.ajax({
                url: "{{ route('orders.resend_details', ['id'=>$order->id]) }}",
                type: "POST",
                data: {'_token': "{{ csrf_token() }}"}
            }).done(function (res){
                if(res.status == 'ok'){
                    $.notify("Details Sent!", 'success');
                }else{
                    $.notify(res.error, 'error');
                }
            });
        });
    </script>
@endsection