@extends('partials.app_nav')

@section('content')
    <form class="form-horizontal" action="" method="post">
        <fieldset>
            <legend>Confirm Delete ?</legend>
            <div class="form-group">
                <label class="col-md-4 control-label" for="confirm">Type Yes to Confirm</label>
                <div class="col-md-6">
                    <input id="confirm" name="confirm" type="text" placeholder="" class="form-control input-md" required="">
                    {!! csrf_field() !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="buttondelete"></label>
                <div class="col-md-8">
                    <button id="delete" name="delete" class="btn btn-danger">Delete</button>
                    <a ="window.location.back()" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </fieldset>
    </form>
@endsection