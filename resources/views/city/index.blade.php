@extends('partials.app_nav')

@section('content')
    <div class="row">
        <div class="col-xs-10">
            <h2>City</h2>
        </div>
        <div class="col-xs-2">
            <a style="margin-top: 25px;" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#addModal" href="#addModal"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div>
    </div>
    <hr>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="10%">#</th>
            <th>Name</th>
            <th width="20%">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach(\App\City::orderBy("name", 'asc')->get() as $index=>$city)
                <tr>
                    <td>{{ ($index+1) }}</td>
                    <td>{{ $city->name }}</td>
                    <td>
                        <a href="#" onclick="removeCity('{{ $city->id }}')" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete City</a>
                        <a href="#addArea" data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-target="#addArea" data-toggle="modal" class="btn btn-xs btn-success"><i class=" glyphicon glyphicon-plus"></i> Area</a>
                        <a href="#viewArea" data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-target="#viewArea" data-toggle="modal" class="btn btn-xs btn-primary"><i class=" glyphicon glyphicon-list"></i> View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="viewArea" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">View Area</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr><th>#</th><th>Name</th><th>Action</th></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addArea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Area</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" onsubmit="return false;">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="area">Area</label>
                                <div class="col-md-6">
                                    <input id="area" name="area" type="text" placeholder="" class="form-control input-md" required="">
                                    <input id="city_id" name="city_id" type="hidden" />
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addArea()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add City</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="form-horizontal">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="city">City</label>
                                <div class="col-md-6">
                                    <input id="city" name="city" type="text" placeholder="" class="form-control input-md" required="">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addCity()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#viewArea').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            var html = '';
            $.ajax({
                url: "{{ route('viewArea') }}",
                async: true,
                type:"POST",
                data: {"city_id": id, "_token": "{{ csrf_token() }}"}
            }).done(function (e){
                if(e == 'not found')
                {
                    alert("No Records to display.");
                    $("#viewArea").modal('hide');
                }
                else
                {
                    var data = JSON.parse(e);
                    for(i=0; i<data.length; i++)
                    {
                        html += '<tr>' + '<td>' + (i+1) + '</td>'
                                + '<td>' + data[i]['name'] + '</td>'
                                + '<td>' + '<a href="#" data-id="'+data[i]['id']+'" data-do="editArea" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i> Edit</a> '
                                + '<a href="#" data-do="delArea" data-id="'+data[i]['id']+'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Del</a>' + '</td>' + "</tr>";
                    }
                    $("#viewArea .modal-body tbody").html(html);

                    $('[data-do="editArea"]').click(function (){
                        var s = prompt("Enter new Name ? ", '');
                        var id = $(this).data('id');
                        var btn = $(this);
                        console.log(btn);
                        $.ajax({
                            url: "{{ route('editArea') }}",
                            async: true,
                            type:"POST",
                            data: {"id": id, "name":s,  "_token": "{{ csrf_token() }}"}
                        }).done(function (e) {
                            if (e == 'ok') {
                                $.notify("Updated Successfully.", "success");
                                btn[0].parentNode.parentNode.childNodes[1].innerHTML = s;
                            }else if(e == 'duplicate'){
                                alert("Duplicate Area Name in Same City. ");
                            }
                        });
                    });

                    $('[data-do="delArea"]').click(function (){
                        var btn = $(this)[0];
                        if(confirm("Are you sure ?"))
                        {
                            var id = $(this).data('id');
                            $.ajax({
                                url: "{{ route('delArea') }}",
                                async: true,
                                type:"POST",
                                data: {"id": id, "_token": "{{ csrf_token() }}"}
                            }).done(function (e) {
                                if (e == 'ok') {
                                    $.notify('Area Deleted.', 'error');
                                    btn.parentNode.parentNode.remove();
                                }else{
                                    $.notify('Error.', 'error');
                                }
                            });
                        }
                    });
                }
            });
            modal.find('.modal-title ').text("View Area : "+button.data('name'));
        });

        $('#addArea').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #city_id').val(id);
            modal.find('.modal-title ').text("Add Area : "+button.data('name'));
        });

        function addArea()
        {
            if($("#area").val().length > 0)
            {
                $("#addArea").modal("hide");
                var area = $("#area").val();
                var id = $("#city_id").val();
                $.ajax({
                    url: "{{ route('addArea') }}",
                    async: true,
                    type:"POST",
                    data: {"city_id": id, "name":area, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='saved'){
                        $.notify("Area Added.", "success");
                        $("#area").val("");
                    }else if(e == 'duplicate'){
                        alert("Error: Duplicate Area Name in Same City. ");
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }

        function addCity()
        {
            if($("#city").val().length > 0)
            {
                $("#addCity").modal("hide");
                var city = $("#city").val();
                $.ajax({
                    url: "{{ route('addCity') }}",
                    async: true,
                    type:"POST",
                    data: {"name":city, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='saved'){
                        window.location.reload();
                    }else{
                        var msg = JSON.parse(e);
                        console.log(msg);
                        alert("Error: "+msg['name'][0]);
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }

        function removeCity(id)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "{{ route('removeCity') }}",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='ok'){
                        window.location.reload();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }
    </script>
@endsection