@extends('partials.app_nav')

@section('content')
    @include('partials.pagetitle', ["page_title"=>"Restaurants", "button_link"=>route('restaurants.add')])

    <form class="form-horizontal" action="" method="get" id="select_city">
        <fieldset>
            <div class="form-group">
                <label class="col-md-4 control-label" for="city">City</label>
                <div class="col-md-6">
                    <select id="city" name="city" onchange="$('#select_city').submit()" class="form-control">
                        <option value="">--select--</option>
                        @foreach(\App\City::get() as $city)
                            <option value="{{ $city->id }}" {{ ($city->id == Request::get('city'))?"selected":'' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </fieldset>
    </form>

    @if(Request::has('city') && Request::get('city') != '')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>City</th>
            <th>Contact</th>
            <th>Outstanding</th>
            <th width="33%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Restaurant::where('city_id', Request::get('city'))->get() as $index => $restaurant)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $restaurant->name }}</td>
                <td>{{ \App\City::where("id", $restaurant->city_id)->first()->name }}</td>
                <td>{{ $restaurant->contact_no }}</td>
                <td>Rs. {{ $restaurant->orders->sum('gtotal')*0.9 }}</td>
                <td>
                    <a href="{{ route('restaurants.orders', ["id"=>$restaurant->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list"></i> Orders</a>
                    <a href="{{ route('restaurants.menu', ["id"=>$restaurant->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list"></i> Menu</a>
                    <a href="{{ route('restaurants.view', ["id"=>$restaurant->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list"></i> View</a>
                    <a href="{{ route('restaurants.time', ["id"=>$restaurant->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> T&A</a>
                    <a href="{{ route('restaurants.edit', ["id"=>$restaurant->id]) }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                    <a href="{{ route('restaurants.delete', ['id'=>$restaurant->id]) }}" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
@endsection

@section('script')

@endsection