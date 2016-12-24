@extends('partials.app_nav')

@section('content')
    @include('restaurants.form', ["edit"=>"yes"])
@endsection