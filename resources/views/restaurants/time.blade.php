@extends('partials.app_nav')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
@endsection


@section('content')
    <form class="form-horizontal">
        <fieldset>

            <!-- Form Name -->
            <legend>Area Select</legend>

            <!-- Select Multiple -->
            <div class="form-group">
                <label class="col-md-2 control-label" for="area">Area</label>
                <div class="col-md-10">
                    <select id="area" name="area" class="form-control" multiple="multiple">
                        @foreach(\App\Area::where('city_id', $restaurant->city_id)->get() as $area)
                            <option {{ $area->restaurant_id!=''?(in_array($restaurant->id, json_decode($area->restaurant_id, true))==true?'selected':''):'' }} data-select="area" data-area_id="{{ $area->id }}" id="area_{{ $area->id }}" name="area_{{ $area->id }}"/>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btn-primary pull-right" onclick="save_area()">Save</button>
        </fieldset>
    </form>

    <br/>
    <hr>
    {{--<table class="table table-bordered">--}}
        {{--<thead>--}}
        {{--<tr>--}}
            {{--<th width="5%">Select?</th>--}}
            {{--<th>Area Name</th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@foreach(\App\Area::where('city_id', $restaurant->city_id)->get() as $area)--}}
            {{--<tr>--}}
                {{--<td><input type="checkbox" {{ $area->restaurant_id!=''?(in_array($restaurant->id, json_decode($area->restaurant_id, true))==true?'checked':''):'' }} data-select="area" data-area_id="{{ $area->id }}" id="area_{{ $area->id }}" name="area_{{ $area->id }}"/></td>--}}
                {{--<td><label for="area_{{ $area->id }}">{{ $area->name }}</label></td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
        {{--<tfoot>--}}
        {{--<tr>--}}
            {{--<td></td>--}}
            {{--<td><button class="btn btn-sm btn-primary pull-right" onclick="save_area()">Save</button></td>--}}
        {{--</tr>--}}
        {{--</tfoot>--}}
    {{--</table>--}}

    @if($restaurant->train_time != null)
        @include('restaurants.partials.time_table', ['title'=>'Train Delivery Timings', 'alias'=>'train'])
    @endif

    @if($restaurant->pickup_time != null)
        @include('restaurants.partials.time_table', ['title'=>'Pickup Timings', 'alias'=>'pkp'])
    @endif

    @if($restaurant->delivery_time != null)
        @include('restaurants.partials.time_table', ['title'=>'Delivery Timings', 'alias'=>'del'])
    @endif

    @if($restaurant->dinein_time != null)
        @include('restaurants.partials.time_table', ['title'=>'Dinein Timings', 'alias'=>'dine'])
    @endif

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <script>
        var days = ["mon", 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        var delivery_hours = JSON.parse('{!! $restaurant->delivery_hours?:"{}" !!}');
        var pickup_hours = JSON.parse('{!! $restaurant->pickup_hours?:"{}" !!}');
        var dinein_hours = JSON.parse('{!! $restaurant->dinein_hours?:"{}" !!}');
        var train_hours = JSON.parse('{!! $restaurant->train_hours?:"{}" !!}');
        var uncheck = [];

        $(document).ready(function(){
            $("#area").select2();
            @if($restaurant->delivery_time != null)
                load_data(delivery_hours, 'del');
            @endif
            @if($restaurant->pickup_time != null)
                load_data(pickup_hours, 'pkp');
            @endif
            @if($restaurant->dinein_time != null)
                load_data(dinein_hours, 'dine');
            @endif
            @if($restaurant->train_time != null)
                load_data(train_hours, 'train');
            @endif

            $('#area').on('select2:unselect', function (evt) {
                uncheck.push(evt.params.data.element.dataset.area_id);
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
                if(v.selected == true)
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