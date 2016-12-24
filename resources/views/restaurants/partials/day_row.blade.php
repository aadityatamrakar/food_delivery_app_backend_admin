<tr>
    <td>{{ $day }}</td>
    <td>
        <select class="form-control" data-toggle="open_close_day" data-alias="{{ $day_alias }}" data-del_pickup="{{ $del_pickup }}" name="{{ $del_pickup }}_{{ $day_alias }}_oc" id="{{ $del_pickup }}_{{ $day_alias }}_oc">
            <option selected value="0">Close</option>
            <option value="1">Open</option>
        </select>
    </td>
    <td>
        <select disabled class="form-control" data-alias="{{ $day_alias }}" data-del_pickup="{{ $del_pickup }}" name="{{ $del_pickup }}_{{ $day_alias }}_open_time" id="{{ $del_pickup }}_{{ $day_alias }}_open_time"/>
            @for ($i = 0; $i < 24; $i++)
                @for ($j = 0; $j < 46; $j+=15)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}{{ str_pad($j, 2, '0') }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($j, 2, '0') }}</option>
                @endfor
            @endfor
            <option value="2400">24:00</option>
        </select>
    </td>
    <td>
        <select disabled class="form-control" data-alias="{{ $day_alias }}" data-del_pickup="{{ $del_pickup }}" name="{{ $del_pickup }}_{{ $day_alias }}_close_time" id="{{ $del_pickup }}_{{ $day_alias }}_close_time"/>
        @for ($i = 0; $i < 24; $i++)
            @for ($j = 0; $j < 46; $j+=15)
                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}{{ str_pad($j, 2, '0') }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:{{ str_pad($j, 2, '0') }}</option>
            @endfor
        @endfor
            <option value="2400">24:00</option>
        </select>
    </td>
</tr>

