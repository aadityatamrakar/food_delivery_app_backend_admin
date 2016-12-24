@extends('partials.app_nav')

@section('content')
    <form class="form-horizontal" method="post" action="{{ $edit==false?route('restaurants.addCategory', ['id'=>$restaurant_id]):route('restaurants.editCategory', ['id'=>$restaurant_id, 'category_id'=>$category->id]) }}">
        <fieldset>
            <legend>{{ $edit==true?"Edit":"Add" }} Category</legend>
            {!! csrf_field() !!}
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">Name</label>
                <div class="col-md-6">
                    <input id="title" name="title" type="text" value="{{ isset($category)?$category->title:'' }}" class="form-control input-md" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="save"></label>
                <div class="col-md-8">
                    <button id="save" name="save" value="ok" class="btn btn-success">Save</button>
                    @if($edit != true)
                        <button id="savenext" name="savenext" value="ok" class="btn btn-info">Save &amp; Next</button>
                    @endif
                </div>
            </div>
        </fieldset>
    </form>
@endsection