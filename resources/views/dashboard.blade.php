@extends('partials.app_nav')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Orders WFRA</div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="order_wfra">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Restaurant</th>
                            <th>Res. Phone</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @each('dashboard.orders_detail', \App\Order::where('status', 'WFRA')->get(), 'order')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Orders Processing</div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="order_proc">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Restaurant</th>
                            <th>Res. Phone</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @each('dashboard.orders_detail', \App\Order::where('status', 'PROC')->get(), 'order')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Complete Orders</div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="all_orders">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Restaurant</th>
                            <th>Res. Phone</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @each('dashboard.orders_detail', \App\Order::where('status', 'CMPT')->get(), 'order')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
            $("#all_orders").dataTable();
            $("#order_proc").dataTable();
            $("#order_wfra").dataTable();

            setTimeout(function (){
                window.location.reload();
            }, 10000);
        })
    </script>
@endsection
