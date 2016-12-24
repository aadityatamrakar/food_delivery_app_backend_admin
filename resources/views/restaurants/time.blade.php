@extends('partials.app_nav')

@section('content')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">Select?</th>
                <th>Area Name</th>
            </tr>
        </thead>
        <tbody>
        @foreach(\App\Area::where('city_id', $restaurant->city_id)->get() as $area)
            <tr>
                <td><input type="checkbox" {{ $area->restaurant_id!=''?(in_array($restaurant->id, json_decode($area->restaurant_id, true))==true?'checked':''):'' }} data-select="area" data-area_id="{{ $area->id }}" id="area_{{ $area->id }}" name="area_{{ $area->id }}"/></td>
                <td><label for="area_{{ $area->id }}">{{ $area->name }}</label></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td><button class="btn btn-sm btn-primary pull-right" onclick="save_area()">Save</button></td>
        </tr>
        </tfoot>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="4">Pickup Timings</th>
        </tr>
        <tr>
            <th>Day</th>
            <th>Open/Close</th>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>
            @include('restaurants.partials.day_row', ["day"=>"Monday", "day_alias"=>"mon", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Tuesday", "day_alias"=>"tue", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Wednesday", "day_alias"=>"wed", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Thursday", "day_alias"=>"thu", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Friday", "day_alias"=>"fri", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Saturday", "day_alias"=>"sat", "del_pickup"=>"pkp"])
            @include('restaurants.partials.day_row', ["day"=>"Sunday", "day_alias"=>"sun", "del_pickup"=>"pkp"])
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td><button onclick="save_hours('pkp')" class="btn btn-primary btn-block">Save</button></td>
        </tr>
        </tfoot>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="4">Delivery Timings</th>
        </tr>
        <tr>
            <th>Day</th>
            <th>Open/Close</th>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>
            @include('restaurants.partials.day_row', ["day"=>"Monday", "day_alias"=>"mon", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Tuesday", "day_alias"=>"tue", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Wednesday", "day_alias"=>"wed", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Thursday", "day_alias"=>"thu", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Friday", "day_alias"=>"fri", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Saturday", "day_alias"=>"sat", "del_pickup"=>"del"])
            @include('restaurants.partials.day_row', ["day"=>"Sunday", "day_alias"=>"sun", "del_pickup"=>"del"])
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><button onclick="save_hours('del')" class="btn btn-primary btn-block">Save</button></td>
            </tr>
        </tfoot>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="4">Dinein Timings</th>
        </tr>
        <tr>
            <th>Day</th>
            <th>Open/Close</th>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>
        @include('restaurants.partials.day_row', ["day"=>"Monday", "day_alias"=>"mon", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Tuesday", "day_alias"=>"tue", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Wednesday", "day_alias"=>"wed", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Thursday", "day_alias"=>"thu", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Friday", "day_alias"=>"fri", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Saturday", "day_alias"=>"sat", "del_pickup"=>"dine"])
        @include('restaurants.partials.day_row', ["day"=>"Sunday", "day_alias"=>"sun", "del_pickup"=>"dine"])
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td><button onclick="save_hours('dine')" class="btn btn-primary btn-block">Save</button></td>
        </tr>
        </tfoot>
    </table>
@endsection

@section('script')
    <script>
        var days = ["mon", 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        var delivery_hours = JSON.parse('{!! $restaurant->delivery_hours?:"{}" !!}');
        var pickup_hours = JSON.parse('{!! $restaurant->pickup_hours?:"{}" !!}');
        var dinein_hours = JSON.parse('{!! $restaurant->dinein_hours?:"{}" !!}');
        var uncheck = [];

        $(document).ready(function(){
            load_data(delivery_hours, 'del');
            load_data(pickup_hours, 'pkp');
            load_data(dinein_hours, 'dine');

            $('input[data-select="area"]:checked').on('change', function(){
                if($(this).is('checked') == false)
                {
                    uncheck.push($(this).data('area_id'));
                }
            });
        });

        function load_data(data, d)
        {
            console.log(data, d);
            $.each(data, function (i, v){
                $("#"+d+"_"+i+"_oc").val('1');
                $("#"+d+"_"+i+"_open_time").removeAttr('disabled');
                $("#"+d+"_"+i+"_close_time").removeAttr('disabled');
                $("#"+d+"_"+i+"_open_time").val(v['open_time']);
                $("#"+d+"_"+i+"_close_time").val(v['close_time']);
            });
        }

        $('[data-toggle="open_close_day"]').on('change', document, function(e){
            var select = $(this);
            var alias = $(this).data('alias');
            var del_pickup = $(this).data('del_pickup');
            if($(this).val() == 'Close')
            {
                $("#"+del_pickup+"_"+alias+"_open_time").attr('disabled', '');
                $("#"+del_pickup+"_"+alias+"_close_time").attr('disabled', '');
            }
            else
            {
                $("#"+del_pickup+"_"+alias+"_open_time").removeAttr('disabled');
                $("#"+del_pickup+"_"+alias+"_close_time").removeAttr('disabled');
            }
        });
        function save_hours(x)
        {
            var s = "#"+x+"_";
            var data = {};
            $.each(days, function (i, d){
                if($(s+d+"_oc").val() == '1')
                {
                    data[d] = {"open_time": $(s+d+"_open_time").val(), "close_time": $(s+d+"_close_time").val()};
                }
            });

            console.log(data);
            var t = JSON.stringify(data);
            $.ajax({
                url: "{{ route('restaurants.time', ["id"=>$id]) }}/"+x,
                type:"POST",
                async:true,
                data: {"data": t, "_token": "{{ csrf_token() }}"}
            }).done(function (e){
                if(e == 'ok')
                {
                    $.notify('Saved Successfully.', 'success');
                }
            });
        }

        function save_area()
        {
            var data = [];
            var areas = $('[data-select="area"]');
            $.each(areas, function (i, v){
                if(v.checked == true)
                {
                    data.push(v.dataset.area_id);
                }
            });
            console.log(data);
            var t = JSON.stringify(data);
            var t2 = JSON.stringify(uncheck);
            $.ajax({
                url: "{{ route('restaurants.area', ["id"=>$id]) }}",
                type:"POST",
                async:true,
                data: {"data": t, "uncheck":t2, "_token": "{{ csrf_token() }}"}
            }).done(function (e){
                if(e == 'ok')
                {
                    $.notify('Saved Successfully.', 'success');
                }
            });
        }
    </script>
@endsection