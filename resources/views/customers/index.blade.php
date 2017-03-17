@extends('partials.app_nav')

@section('content')
    <h2>Customers</h2>
    <hr>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>City</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach(\App\Customer::orderBy('created_at', 'desc')->get() as $index=>$customer)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->mobile }}</td>
                    <td>{{ \App\City::find($customer->city)->name }}</td>
                    <td><a href="{{ route('customers.wallet', ['id'=>$customer->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-bitcoin"></i> Wallet</a> <a href="{{ route('customers.orders', ['id'=>$customer->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Orders</a> <a href="{{ route('customers.view', ['id'=>$customer->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-user"></i> View</a> <a href="#" onclick="removeCustomer('{{ $customer->id }}', this)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-user"></i> Del</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function removeCustomer(id, t)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "{{ route('removeCustomer') }}",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='ok'){
                        $.notify("Customer Deleted.", "success");
                        $(t).parent().parent().remove();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }
    </script>
@endsection

