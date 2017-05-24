@extends('partials.app_nav')

@section('content')
    @include('partials.pagetitle', ["page_title"=>"Restaurants", "button_link"=>route('restaurants.add')])

    <form class="form-horizontal" action="" method="get" id="select_city">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="city">City</label>
                <div class="col-md-6">
                    <select id="city" name="city" onchange="$('#select_city').submit()" class="form-control">
                        <option value="">--select--</option>
                        @foreach(\App\City::get() as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == Request::get('city'))?"selected":'' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </fieldset>
    </form>

    @if(Request::has('city') && Request::get('city') != '')
    <table class="table table-bordered" id="restaurant_tbl">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="30%">Name</th>
            <th width="5%">City</th>
            <th>Contact</th>
            <th width="5%">Outstanding</th>
            <th width="5%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Restaurant::where('city_id', Request::get('city'))->get() as $index => $restaurant)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $restaurant->name }}</td>
                <td>{{ \App\City::where("id", $restaurant->city_id)->first()->name }}</td>
                <td>{{ $restaurant->contact_no }}</td>
                <td>
                    @if($pc->outstanding($restaurant->id)->outstanding!=0)
                        <button data-toggle="modal" data-target="#paymentRequestModal" data-id="{{ $restaurant->id }}" data-name="{{ $restaurant->name }}" data-outstanding="{{ $pc->outstanding($restaurant->id)->outstanding }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-send"></i></button>
                    @endif
                    Rs. {{ round($pc->outstanding($restaurant->id)->outstanding, 0) }}
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-xs btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Options
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="{{ route('restaurants.orders', ["id"=>$restaurant->id]) }}" ><i class="glyphicon glyphicon-adjust"></i> Orders</a></li>
                            <li><a href="{{ route('restaurants.menu', ["id"=>$restaurant->id]) }}" ><i class="glyphicon glyphicon-book"></i> Menu</a></li>
                            <li><a href="{{ route('restaurants.view', ["id"=>$restaurant->id]) }}" ><i class="glyphicon glyphicon-list"></i> View</a></li>
                            <li><a href="{{ route('restaurants.time', ["id"=>$restaurant->id]) }}" ><i class="glyphicon glyphicon-time"></i> T&A</a></li>
                            <li><a href="{{ route('restaurants.edit', ["id"=>$restaurant->id]) }}" ><i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                            <li><a href="{{ route('restaurants.delete', ['id'=>$restaurant->id]) }}"><i class="glyphicon glyphicon-remove"></i> Del</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td width="5%"></td>
            <td width="30%"></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="5%"></td>
        </tr>
        </tfoot>
    </table>
    @endif


    <div class="modal fade" id="paymentRequestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Request Payment</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="restaurant_name">Restaurant</label>
                                <div class="col-md-6">
                                    <input id="restaurant_name" name="restaurant_name" readonly type="text" placeholder="" class="form-control input-md" required="">
                                    <input id="restaurant_id" name="restaurant_id" readonly type="hidden">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="amount">Amount</label>
                                <div class="col-md-6">
                                    <input id="outstanding" name="outstanding" type="text" placeholder="" class="form-control input-md" required="">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="generate_payment_request()" >Generate</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        function generate_payment_request()
        {
            var restaurant_id = $('#restaurant_id').val();
            var amount = $('#outstanding').val();
            $.ajax({
                url: "{{ route('payment.request') }}",
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", 'amount': amount, "restaurant_id": restaurant_id}
            }).done(function (res){
                if(res.status == 'ok'){
                    $.notify("Requested Successfully.", "success");
                    window.location.reload();
                }else if(res.status == 'error'){
                    alert(res.error);
                }
            });
        }

        $('#paymentRequestModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var restaurant_id = button.data('id');
            var outstanding = button.data('outstanding');
            var restaurant_name = button.data('name');
            $('#restaurant_id').val(restaurant_id);
            $('#restaurant_name').val(restaurant_name);
            $('#outstanding').val(outstanding);
        });

        $(document).ready(function (){
            $('#restaurant_tbl tfoot td').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" class="myinput" placeholder="Search '+title+'" />' );
            } );

            // DataTable
            var table = $('#restaurant_tbl').DataTable();

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
    </script>

@endsection