@extends('partials.app_nav')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
@endsection

@section('content')
    <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('banner.upload') }}">
        <fieldset>
            {!! csrf_field() !!}
            <legend>Add Banner Image</legend>

            <div class="form-group">
                <label class="col-md-4 control-label" for="image">Image</label>
                <div class="col-md-4">
                    <input id="image" name="image" class="input-file" type="file">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="save"></label>
                <div class="col-md-4">
                    <button id="save" name="save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </fieldset>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Banner::all() as $index=>$banner)
            <tr>
                <td>{{ $index+1 }}</td>
                <td><img class="img-thumbnail img-rounded img-responsive" src="/images/banner/mobile/{{ $banner->url }}" style="height: 100px;"></td>
                <td><a class="btn btn-xs btn-danger" href="#" data-toggle="delete_banner" data-href="{{ route('banner.delete', ['id'=>$banner->id]) }}"><i class="glyphicon glyphicon-remove"></i> Del</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $('[data-toggle="delete_banner"]').click(function (e){
            e.preventDefault();
            if(confirm('Are you sure ?'))
                window.location.href = $(this).data('href');
        })
    </script>
@endsection