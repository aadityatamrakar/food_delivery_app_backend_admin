<form class="form-horizontal" method="post" action="{{ $route }}">
    <fieldset>
    {!! csrf_field() !!}
    <!-- Form Name -->
        <legend>{{ $title }} Coupon</legend>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="code">Code</label>
            <div class="col-md-6">
                <input onkeyup="this.value = this.value.toUpperCase();" id="code" name="code" type="text" class="form-control input-md" required="" value="{{ $coupon->code?:old('code') }}">
            </div>
        </div>

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="return_type">Return Type</label>
            <div class="col-md-4">
                <label class="radio-inline" for="return_type-0">
                    <input type="radio" name="return_type" id="return_type-0" value="discount" {{ $coupon->return_type?$coupon->return_type=='discount'?'checked="checked"':'':'checked="checked"' }}>
                    Discount
                </label>
                <label class="radio-inline" for="return_type-1">
                    <input type="radio" name="return_type" id="return_type-1" value="cashback" {{ $coupon->return_type?$coupon->return_type=='cashback'?'checked="checked"':'':'' }}>
                    Cashback
                </label>
            </div>
        </div>

        <!-- Appended Input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="percent">Percent</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input id="percent" name="percent" class="form-control" type="text" required="" value="{{ $coupon->percent?:old('percent') }}">
                    <span class="input-group-addon">%</span>
                </div>

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="max_amount">Max Amount</label>
            <div class="col-md-6">
                <input id="max_amount" name="max_amount" type="text"  class="form-control input-md" required="" value="{{ $coupon->max_amount?:old('max_amount') }}">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="min_amt">Min. Cart Amount</label>
            <div class="col-md-6">
                <input id="min_amt" name="min_amt" type="text"  class="form-control input-md" required="" value="{{ $coupon->min_amt?:old('min_amt') }}">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="valid_from">Valid From</label>
            <div class="col-md-6">
                <input id="valid_from" name="valid_from" type="datetime"  class="form-control input-md" required="" value="{{ $coupon->valid_from?\Carbon\Carbon::parse($coupon->valid_from)->format('m/d/Y h:i A'):old('valid_from') }}">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="valid_till">Valid Till</label>
            <div class="col-md-6">
                <input id="valid_till" name="valid_till" type="datetime"  class="form-control input-md" required="" value="{{ $coupon->valid_till?\Carbon\Carbon::parse($coupon->valid_till)->format('m/d/Y h:i A'):old('valid_till') }}">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="times">Times</label>
            <div class="col-md-6">
                <input id="times" name="times" type="number" min="1"  class="form-control input-md" required="" value="{{ $coupon->times?:old('times') }}">

            </div>
        </div>

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="new_only">New Only ?</label>
            <div class="col-md-4">
                <label class="radio-inline" for="new_only-0">
                    <input type="radio" name="new_only" id="new_only-0" value="yes" {{ $coupon->new_only?$coupon->new_only=='yes'?'checked="checked"':'':'checked="checked"' }}>
                    Yes
                </label>
                <label class="radio-inline" for="new_only-1">
                    <input type="radio" name="new_only" id="new_only-1" value="no" {{ $coupon->new_only?$coupon->new_only=='no'?'checked="checked"':'':'' }}>
                    No
                </label>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="description">Description</label>
            <div class="col-md-6">
                <textarea id="description" name="description" class="form-control">{{ $coupon->description?:old('description') }}</textarea>
            </div>
        </div>
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="save"></label>
            <div class="col-md-4">
                <button id="save" name="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </fieldset>
</form>