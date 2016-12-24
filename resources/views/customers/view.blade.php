@extends('partials.app_nav')

@section('content')
    <h2>User Details: </h2>
    <table class="table-bordered table">
        <tbody>
        <tr>
            <th>Name</th>
            <td>{{ $customer->name }}</td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td>{{ $customer->mobile }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $customer->email }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>{{ $customer->address }}</td>
        </tr>
        <tr>
            <th>City</th>
            <td>{{ \App\City::find($customer->city)->name }}</td>
        </tr>
        <tr>
            <th>Joined</th>
            <td>{{ \Carbon\Carbon::parse($customer->created_at)->diffForHumans() }}</td>
        </tr>
        </tbody>
    </table>
@endsection