@extends('partials.app_nav')

@section('content')
    @include('partials.pagetitle', ['page_title'=>"Product", 'button_link'=>route('restaurants.addProduct', ['id'=>$id])])
    <table class="table table-border">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>MRP</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Category::where('id', $id)->first()->products as $index=>$product)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->mrp }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="{{ route('restaurants.editProduct', ['id'=>$id, 'product_id'=>$product->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="#" onclick="delete_category('{{ $product->id }}')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        function delete_category(id)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "{{ route('delProduct') }}",
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