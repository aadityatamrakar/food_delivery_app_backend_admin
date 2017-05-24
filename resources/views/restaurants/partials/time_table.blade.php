<table class="table table-bordered">
    <thead>
    <tr>
        <th colspan="4">{{ $title }}</th>
    </tr>
    <tr>
        <th>Day</th>
        <th>Open/Close</th>
        <th>From</th>
        <th>To</th>
    </tr>
    </thead>
    <tbody>
    @include('restaurants.partials.day_row', ["day"=>"Monday", "day_alias"=>"mon", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Tuesday", "day_alias"=>"tue", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Wednesday", "day_alias"=>"wed", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Thursday", "day_alias"=>"thu", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Friday", "day_alias"=>"fri", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Saturday", "day_alias"=>"sat", "del_pickup"=>$alias])
    @include('restaurants.partials.day_row', ["day"=>"Sunday", "day_alias"=>"sun", "del_pickup"=>$alias])
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td><button onclick="save_hours('{{ $alias }}')" class="btn btn-primary btn-block">Save</button></td>
    </tr>
    </tfoot>
</table>