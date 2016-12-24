@extends('partials.app_nav')

@section('content')
    @include('restaurants.form', ["edit"=>"no"])
@endsection

