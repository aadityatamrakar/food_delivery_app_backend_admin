@extends('partials.app_nav')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css"/>
@endsection

@section('content')
    <h2>Referral</h2>
    <hr>
    <table class="table table-bordered" id="tbl">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach(\App\Leads::orderBy('created_at', 'desc')->get() as $index=>$customer)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->mobile }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->type }}</td>
                <td><a href="#" onclick="removeCustomer('{{ $customer->id }}', this)" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-user"></i> Del</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
    <script>
        function removeCustomer(id, t)
        {
            if(confirm("Are you sure ?"))
            {
                $.ajax({
                    url: "{{ route('removeReferral') }}",
                    async: true,
                    type:"POST",
                    data: {"id":id, "_token": "{{ csrf_token() }}"}
                }).done(function (e){
                    if(e =='ok'){
                        $.notify("Referral Deleted.", "success");
                        $(t).parent().parent().remove();
                    }
                }).fail(function (m){
                    alert("Error: "+m.responseJSON['name'][0]);
                });
            }
        }

        $("#tbl").DataTable({
            dom: 'Blfrtip',
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    </script>
@endsection

