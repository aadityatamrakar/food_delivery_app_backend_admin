@extends('partials.app_nav')

@section('style')
    <style>
        .myinput{
            width:100%;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    @if(isset($restaurant))
         <h2>Orders | Restaurant: {{ $restaurant->name }}</h2>
    @elseif(isset($customer))
        <h2>Orders | Customer: {{ $customer->name }}</h2>
    @elseif(isset($coupon))
        <h2>Orders | Coupon: {{ $coupon->code }}</h2>
    @else
        <h2>Orders</h2>
    @endif
    <hr>
    <table class="table table-bordered" id="order_tbl">
        <thead>
        <tr>
            <th width="5%">#</th>
            @if(!isset($customer))<th>User</th>@endif
            @if(!isset($restaurant))<th>Restaurant</th>@endif
            <th width="5%">Info</th>
            <th width="5%">Amount</th>
            @if(!isset($coupon))<th width="5%">Coupon</th>@endif
            <th width="5%">Deliver</th>
            <th width="5%">Status</th>
            <th width="5%">Payment</th>
            <th width="5%">City</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $index=>$order)
            <tr>
                <td><a href="{{ route('orders.view', ['id'=>$order->id]) }}">{{ $order->id }}</a></td>
                @if(!isset($customer))<td><a href="{{ route('customers.view', ["id"=>$order->user->id]) }}" target="child">{{ $order->user->name }}</a></td>@endif
                @if(!isset($restaurant))<td><a href="{{ route('restaurants.view', ["id"=>$order->restaurant->id]) }}" target="_blank">{{ $order->restaurant->name }}</a></td>@endif
                <td><a href="{{ route('orders.view', ['id'=>$order->id]) }}">view</a></td>
                <td>{{ $order->gtotal }}</td>
                @if(!isset($coupon))<td>{{ $order->coupon!=''?\App\Coupon::find($order->coupon)->code:'' }}</td>@endif
                <td>{{ $order->deliver }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ ($wallet = App\wallet::where([['order_id', $order->id], ['type', 'added']])->first())!=null?$wallet->mode:"COD" }}</td>
                <td>{{ $order->city }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y h:i:s A') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            @if(!isset($customer))<td></td>@endif
            @if(!isset($restaurant))<td></td>@endif
            <td></td>
            <td></td>
            @if(!isset($coupon))<td></td>@endif
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>

    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cart Details</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th colspan="3">Cart</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody id="cartBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
            $('[data-toggle="popover"]').popover({
                container: 'body',
                placement: 'top',
                title: "User Details"
            });

            $('#order_tbl tfoot td').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="myinput" placeholder="Search '+title+'" />' );
            } );

            // DataTable
            var table = $('#order_tbl').DataTable({
                "aaSorting": [[0,'desc']],
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                                .search( this.value )
                                .draw();
                    }
                } );
            } );
        });

        $('#cartModal').on('show.bs.modal', function (event) {
            var btn = $(event.relatedTarget);
            var cart = JSON.parse(decodeURIComponent(btn.data('cart')));
            var modal = $(this), quantity = 0;
            var html = '', gtotal = btn.data('gtotal'), df= btn.data('df'), pf = btn.data('pf');
            console.log(cart);

            $.each(cart, function (i, v){
                html += '<tr><td>'+v['title']+'</td><td>'+v['quantity']+'</td><td>'+parseFloat(v['quantity']*v['price'])+'</td></tr>';
                quantity += v['quantity'];
            });

            if(df > 0) html+= "<tr><td colspan='2'>Delivery Fee</td><td>"+df+"</td></tr>";
            if(pf > 0) html+= "<tr><td colspan='2'>Packing Fee</td><td>"+pf+"</td></tr>";

            html+= "<tr><td>Total</td><td>"+quantity+"</td><td>"+gtotal+"</td></tr>";
            $("#cartBody").html(html);
        })
    </script>
@endsection