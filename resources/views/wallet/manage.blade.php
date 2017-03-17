@extends('partials.app_nav')

@section('content')
    <form class="form-horizontal" action="{{ route("wallet.update") }}" method="post">
        <fieldset>
        {!! csrf_field() !!}
        <!-- Form Name -->
            <legend>Manage Wallet</legend>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="customer_mobile">Customer Mobile</label>
                <div class="col-md-6">
                    <input id="customer_mobile" name="customer_mobile" type="text" placeholder="" class="form-control input-md" required="">
                    <span>Customer Name: <span id="customer_name">Enter customer mobile no.</span></span>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="wallet_bal">Current Balance</label>
                <div class="col-md-6">
                    <input readonly id="wallet_bal" name="wallet_bal" type="text" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="action">Action</label>
                <div class="col-md-6">
                    <select id="action" name="action" class="form-control">
                        <option value="add">Add</option>
                        <option value="remove">Remove</option>
                    </select>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="amount">Amount</label>
                <div class="col-md-6">
                    <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md" required="">

                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="reason">Reason</label>
                <div class="col-md-6">
                    <input id="reason" name="reason" type="text" class="form-control input-md" required="">

                </div>
            </div>

            <!-- Button (Double) -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="save"></label>
                <div class="col-md-8">
                    <button id="save" name="save" class="btn btn-success">Update</button>
                    <button id="clear" name="clear" class="btn btn-danger">Clear</button>
                </div>
            </div>

        </fieldset>
    </form>

@endsection

@section('script')
    <script>
        $("#customer_mobile").on('keyup', function (){
            if($(this).val().length == 10)
            {
                $.ajax({
                    url: "{{ route('wallet.details') }}",
                    type: "POST",
                    data: {"mobile": $(this).val(), '_token':"{{ csrf_token() }}"}
                }).done(function (e){
                    if(e.status == 'ok')
                    {
                        $("#customer_name").html(e.name);
                        $("#wallet_bal").val(e.bal);
                        $("#customer_mobile").attr('readonly', '');
                    }else{
                        alert(e.error);
                    }
                });
            }
        });
    </script>
@endsection