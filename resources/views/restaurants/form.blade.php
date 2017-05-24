@include('partials.errors')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
@endsection

<form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ $edit=='no'?route('restaurants.add'):route('restaurants.edit', ["id"=>$restaurant->id]) }}">
    <fieldset>
        {!! csrf_field() !!}
        <legend>{{ $edit=='no'?"Add":"Edit" }} Restaurant</legend>
        <div class="form-group">
            <label class="col-md-4 control-label" for="logo">Logo</label>
            <div class="col-md-4">
                <input id="logo" name="logo" class="input-file" type="file">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="name">Name of Restaurant</label>
            <div class="col-md-6">
                <input id="name" name="name" type="text" value="{{ old('name')?:$restaurant->name }}" class="form-control input-md" required>
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="address">Address</label>
            <div class="col-md-4">
                <textarea class="form-control" id="address"  name="address">{{ old('address')?:$restaurant->address }}</textarea>
                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="city">City</label>
            <div class="col-md-6">
                <select id="city_id" name="city_id" class="form-control">
                    <option>--select--</option>
                    @foreach(\App\City::orderBy('name', 'asc')->get() as $city)
                        <option value="{{ $city->id }}" {{ old('city_id')?(old('city_id')==$city->id?"selected":''):($restaurant->city_id == $city->id?"selected":'') }}>{{ $city->name }}</option>
                    @endforeach
                </select>
                {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="pincode">Pincode</label>
            <div class="col-md-6">
                <input id="pincode" name="pincode" value="{{ old('pincode')?:$restaurant->pincode }}" type="text" placeholder="" class="form-control input-md" required="">
                {!! $errors->first('pincode', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="owner_name">Owner Name</label>
            <div class="col-md-6">
                <input id="owner_name" name="owner_name" value="{{ old('owner_name')?:$restaurant->owner_name }}" type="text" placeholder="" class="form-control input-md" required="">
                {!! $errors->first('owner_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="contact_no">Contact No</label>
            <div class="col-md-6">
                <input id="contact_no" name="contact_no" value="{{ old('contact_no')?:$restaurant->contact_no }}" type="text" placeholder="" class="form-control input-md" required="">
                {!! $errors->first('contact_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="contact_no_2">Contact No 2</label>
            <div class="col-md-6">
                <input id="contact_no_2" name="contact_no_2"  value="{{ old('contact_no_2')?:$restaurant->contact_no_2 }}" type="text" placeholder="" class="form-control input-md">
                {!! $errors->first('contact_no_2', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="telephone">Telephone</label>
            <div class="col-md-6">
                <input id="telephone" name="telephone" value="{{ old('telephone')?:$restaurant->telephone }}" type="text" placeholder="" class="form-control input-md">
                {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="email">Email</label>
            <div class="col-md-6">
                <input id="email" name="email" type="text" value="{{ old('email')?:$restaurant->email }}" class="form-control input-md" required="">
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="type">Veg/Non Veg</label>
            <div class="col-md-4">
                <label class="radio-inline" for="veg-0">
                    <input type="radio" name="type" id="type-0" value="Pure Veg" {{ old('type')?(old('type')=="Pure Veg"?"checked":''):($restaurant->type=="Pure Veg"?"checked":'') }}>
                    Pure Veg
                </label>
                <label class="radio-inline" for="veg-1">
                    <input type="radio" name="type" id="type-1" value="Non-Veg Only" {{ old('type')?(old('type')=="Non-Veg Only"?"checked":''):($restaurant->type=="Non-Veg Only"?"checked":'') }}>
                    Non-Veg Only
                </label>
                <label class="radio-inline" for="veg-2">
                    <input type="radio" name="type" id="type-2" value="Veg & Non-Veg" {{ old('type')?(old('type')=="Veg & Non-Veg"?"checked":''):($restaurant->type=="Veg & Non-Veg"?"checked":'') }}>
                    Veg & Non-Veg
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="vat_tax">VAT Tax</label>
            <div class="col-md-6">
                <input id="vat_tax" name="vat_tax" type="text" value="{{ old('vat_tax')?:$restaurant->vat_tax }}" class="form-control input-md">
                {!! $errors->first('vat_tax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="svc_tax">Service Tax</label>
            <div class="col-md-6">
                <input id="svc_tax" name="svc_tax" type="text" value="{{ old('svc_tax')?:$restaurant->svc_tax }}" class="form-control input-md">
                {!! $errors->first('svc_tax', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="speciality">Most popular dish</label>
            <div class="col-md-6">
                <input id="speciality" name="speciality" type="text" value="{{ old('speciality')?:$restaurant->speciality }}" class="form-control input-md" required="">
                {!! $errors->first('speciality', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="comm_percent">Commission Percent</label>
            <div class="col-md-6">
                <input id="comm_percent" name="comm_percent" type="text" value="{{ old('comm_percent')?:$restaurant->comm_percent }}" class="form-control input-md" required="">
                {!! $errors->first('comm_percent', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="cuisines">Cuisines</label>
            <div class="col-md-6">
                <select class="form-control" multiple="multiple" name="cuisines[]" id="cuisines">
                    @include('restaurants.partials.cuisines')
                </select>
                {!! $errors->first('cuisines', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <!-- Prepended checkbox -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="train_time">Train ?</label>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" {{ $restaurant->train_time!=null?'checked':'' }} data-target="train_time" data-toggle="toggle_check">
                    </span>
                    <input id="train_time" {{ $restaurant->train_time==null?'disabled':'' }} name="train_time" placeholder="Train Time" type="text" value="{{ old('train_time')?:$restaurant->train_time }}" class="form-control input-md" required="">
                    {!! $errors->first('train_time', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>


        <!-- Prepended checkbox -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="delivery_time">Delivery ?</label>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" {{ $restaurant->delivery_time!=null?'checked':'' }} data-target="delivery_time" data-toggle="toggle_check">
                    </span>
                    <input id="delivery_time" {{ $restaurant->delivery_time==null?'disabled':'' }} name="delivery_time" placeholder="Delivery Time" type="text" value="{{ old('delivery_time')?:$restaurant->delivery_time }}" class="form-control input-md" required="">
                    {!! $errors->first('delivery_time', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="pickup_time">Pickup ?</label>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" {{ $restaurant->pickup_time!=null?'checked':'' }} data-target="pickup_time" data-toggle="toggle_check">
                    </span>
                    <input id="pickup_time" {{ $restaurant->pickup_time==null?'disabled':'' }} name="pickup_time" placeholder="Pickup Time" type="text" value="{{ old('pickup_time')?:$restaurant->pickup_time }}" class="form-control input-md" required="">
                    {!! $errors->first('pickup_time', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="dinein_time">Dinein ?</label>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" {{ $restaurant->dinein_time!=null?'checked':'' }} data-target="dinein_time" data-toggle="toggle_check">
                    </span>
                    <input id="dinein_time" {{ $restaurant->dinein_time==null?'disabled':'' }} name="dinein_time" placeholder="Dine-in Time" type="text" value="{{ old('dinein_time')?:$restaurant->dinein_time }}" class="form-control input-md" required="">
                    {!! $errors->first('dinein_time', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="delivery_fee">Delivery Fee</label>
            <div class="col-md-6">
                <input id="delivery_fee" name="delivery_fee" type="text" value="{{ old('delivery_fee')?:$restaurant->delivery_fee }}" class="form-control input-md" required="">
                {!! $errors->first('delivery_fee', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="min_delivery_amt">Min. Delivery Amount</label>
            <div class="col-md-6">
                <input id="min_delivery_amt" name="min_delivery_amt" type="text" value="{{ old('min_delivery_amt')?:$restaurant->min_delivery_amt }}" class="form-control input-md" required="">
                {!! $errors->first('min_delivery_amt', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="packing_fee">Packing Fee</label>
            <div class="col-md-6">
                <input id="packing_fee" name="packing_fee" type="text" value="{{ old('packing_fee')?:$restaurant->packing_fee }}" class="form-control input-md">
                {!! $errors->first('packing_fee', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="payment_modes">COD Available</label>
            <div class="col-md-4">
                <label class="radio-inline" for="payment_modes-0">
                    <input type="radio" name="payment_modes" id="payment_modes-0" value="Yes" {{ old('payment_modes')?(old('payment_modes')=="Yes"?"checked":''):($restaurant->payment_modes=="Yes"?"checked":'') }}>
                    Yes
                </label>
                <label class="radio-inline" for="payment_modes-1">
                    <input type="radio" name="payment_modes" id="payment_modes-1" value="No" {{ old('payment_modes')?(old('payment_modes')=="No"?"checked":''):($restaurant->payment_modes=="No"?"checked":'') }}>
                    No
                </label>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="tin">TIN</label>
            <div class="col-md-6">
                <input id="tin" name="tin" type="text" value="{{ old('tin')?:$restaurant->tin }}" class="form-control input-md">
                {!! $errors->first('tin', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="pan">PAN</label>
            <div class="col-md-6">
                <input id="pan" name="pan" type="text" value="{{ old('pan')?:$restaurant->pan }}" class="form-control input-md">
                {!! $errors->first('pan', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="account_holder">Account Holder</label>
            <div class="col-md-6">
                <input id="account_holder" name="account_holder" type="text" value="{{ old('account_holder')?:$restaurant->account_holder }}" class="form-control input-md" required="">
                {!! $errors->first('account_holder', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="account_no">Account No.</label>
            <div class="col-md-6">
                <input id="account_no" name="account_no" type="text" value="{{ old('account_no')?:$restaurant->account_no }}" class="form-control input-md" required="">
                {!! $errors->first('account_no', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="account_bank">Bank Name</label>
            <div class="col-md-6">
                <input id="account_bank" name="account_bank" type="text" value="{{ old('account_bank')?:$restaurant->account_bank }}" class="form-control input-md" required="">
                {!! $errors->first('account_bank', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="account_ifsc">Account IFSC</label>
            <div class="col-md-6">
                <input id="account_ifsc" name="account_ifsc" type="text" value="{{ old('account_ifsc')?:$restaurant->account_ifsc }}" class="form-control input-md" required="">
                {!! $errors->first('account_ifsc', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="save"></label>
            <div class="col-md-4">
                <button id="save" name="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </fieldset>
</form>

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#cuisines").select2();
        })

        $('[data-toggle="toggle_check"]').on('click', function (){
            if(this.checked) {

                $('#'+$(this).data('target')).removeAttr('disabled');
            }else{
                $('#'+$(this).data('target')).attr('disabled', '');
            }
        });

    </script>
@endsection