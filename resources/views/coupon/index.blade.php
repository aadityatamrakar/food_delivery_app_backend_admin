@extends('partials.app_nav')

@section('content')
    @include('partials.pagetitle', ["button_text"=>"Add", "button_link"=>route('coupon.add'), "page_title"=>"Coupons"])
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Code</th>
            <th>Percent</th>
            <th>Max Amount</th>
            <th>Min. Amount</th>
            <th>Return Type</th>
            <th>Valid From</th>
            <th>Valid Till</th>
            <th>Times</th>
            <th>New Only</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Coupon::all() as $index=>$coupon)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->percent }}</td>
                <td>{{ $coupon->max_amount }}</td>
                <td>{{ $coupon->min_amt }}</td>
                <td>{{ $coupon->return_type }}</td>
                <td>{{ $coupon->valid_from }}</td>
                <td>{{ $coupon->valid_till }}</td>
                <td>{{ $coupon->times }}</td>
                <td>{{ $coupon->new_only }}</td>
                <td><a href="{{ route('coupon.edit', ['id'=>$coupon->id]) }}" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="#" onclick="removeCoupon('{{ $coupon->id }}}')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function removeCoupon(id)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "{{ route('coupon.remove') }}",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='ok'){
                        window.location.reload();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }
    </script>
@endsection