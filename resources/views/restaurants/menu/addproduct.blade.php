@extends('partials.app_nav')

@section('content')
    <form class="form-horizontal" method="post" action="{{ $edit==false?route('restaurants.addProduct', ['id'=>$category_id]):route('restaurants.editProduct', ['id'=>$category_id, 'product_id'=>$product->id]) }}">
        <fieldset>
            <legend>{{ $edit==true?"Edit":"Add" }} Product</legend>
            {!! csrf_field() !!}
            <div class="form-group">
                <label class="col-md-4 control-label" for="title">Name</label>
                <div class="col-md-6">
                    <input id="title" name="title" type="text" value="{{ old('title')?:isset($product)?$product->title:'' }}" class="form-control input-md" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="mrp">MRP</label>
                <div class="col-md-6">
                    <input id="mrp" name="mrp" type="text" value="{{ old('mrp')?:isset($product)?$product->mrp:'' }}" class="form-control input-md" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="price">Price</label>
                <div class="col-md-6">
                    <input id="price" name="price" type="text" value="{{ old('price')?:isset($product)?$product->price:'' }}" class="form-control input-md" required="">
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