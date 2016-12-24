@extends('partials.app_nav')

@section('content')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="2" class="text-center text-uppercase">Restaurant Details</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Logo</th>
            <td><img width="120px" height="120px" src="/images/restaurant/logo/{{ $restaurant->logo }}"></td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $restaurant->name }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $restaurant->address }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ \App\City::where('id', $restaurant->city_id)->first()->name }}</td>
        </tr>
        <tr>
            <th>Pincode</th>
            <td>{{ $restaurant->pincode }}</td>
        </tr>
        <tr>
            <th>Owner Name</th>
            <td>{{ $restaurant->owner_name }}</td>
        </tr>
        <tr>
            <th>Contact No</th>
            <td>{{ $restaurant->contact_no }}</td>
        </tr>
        <tr>
            <th>Contact No 2</th>
            <td>{{ $restaurant->contact_no_2 }}</td>
        </tr>
        <tr>
            <th>Telephone</th>
            <td>{{ $restaurant->telephone }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $restaurant->email }}</td>
        </tr>
        <tr>
            <th>Veg / Non Veg</th>
            <td>{{ $restaurant->type }}</td>
        </tr>
        <tr>
            <th>Cuisines</th>
            <td>{{ implode(', ', json_decode($restaurant->cuisines, true)) }}</td>
        </tr>
        <tr>
            <th>Speciality</th>
            <td>{{ $restaurant->speciality }}</td>
        </tr>
        <tr>
            <th>Commission Percent</th>
            <td>{{ $restaurant->comm_percent }} %</td>
        </tr>
        <tr>
            <th>Delivery Time</th>
            <td>{{ $restaurant->delivery_time }} Mins</td>
        </tr>
        <tr>
            <th>Pickup Time</th>
            <td>{{ $restaurant->pickup_time }} Mins</td>
        </tr>
        <tr>
            <th>Dine in Time</th>
            <td>{{ $restaurant->dinein_time }} Mins</td>
        </tr>
        <tr>
            <th>Delivery Fee</th>
            <td>Rs. {{ $restaurant->delivery_fee }}</td>
        </tr>
        <tr>
            <th>Min Delivery Amount</th>
            <td>Rs. {{ $restaurant->min_delivery_amt }}</td>
        </tr>
        <tr>
            <th>Packing Fee</th>
            <td>Rs. {{ $restaurant->packing_fee }}</td>
        </tr>
        <tr>
            <th>COD Available</th>
            <td>{{ $restaurant->payment_modes }}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Bank Details</th>
        </tr>
        <tr>
            <th>Account Holder</th>
            <td>{{ $restaurant->account_holder }}</td>
        </tr>
        <tr>
            <th>Account No</th>
            <td>{{ $restaurant->account_no }}</td>
        </tr>
        <tr>
            <th>Bank Name</th>
            <td>{{ $restaurant->account_bank }}</td>
        </tr>
        <tr>
            <th>Bank IFSC</th>
            <td>{{ $restaurant->account_ifsc }}</td>
        </tr>
        <tr>
            <th>QR Code</th>
            <td><img src="data:image/png;base64,{{DNS2D::getBarcodePNG(str_pad($restaurant->id, 6, '0', STR_PAD_LEFT), 'QRCODE')}}" alt="barcode" /></td>
        </tr>
        </tbody>
    </table>
@endsection