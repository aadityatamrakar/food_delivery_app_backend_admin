@extends('partials.app_nav')

@section('content')
    @include('partials.pagetitle', ['page_title'=>"Category", 'button_link'=>route('restaurants.addCategory', ['id'=>$restaurant->id])])
    <table class="table table-border">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Restaurant::where('id', $restaurant->id)->first()->categories as $index=>$category)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $category->title }}</td>
                    <td>
                        <a href="{{ route('restaurants.category', ['id'=>$category->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list"></i> Product</a>
                        <a href="{{ route('restaurants.editCategory', ['id'=>$restaurant->id, 'category_id'=>$category->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="#" onclick="delete_category('{{ $category->id }}')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a>
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
                    url: "{{ route('delCategory') }}",
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