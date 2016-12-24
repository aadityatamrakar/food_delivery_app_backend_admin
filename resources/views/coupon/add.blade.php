@extends('partials.app_nav')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.css" />
@endsection

@section('content')
    @include('partials.errors')
    @include('coupon.form', ['title'=>'Add', 'route'=>route('coupon.add')])
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#valid_from").datetimepicker();
            $("#valid_till").datetimepicker();
        });
    </script>
@endsection