<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Restaurant;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function indexRestaurant($id)
    {
        $restaurant = Restaurant::find($id);
        $orders = $restaurant->orders->sortByDesc('created_at')->all();
        return view('orders.index', compact(['restaurant', 'orders']));
    }

    public function indexCustomer($id)
    {
        $customer = Customer::where('id', $id)->first();
        $orders = $customer->orders->sortByDesc('created_at')->all();
        return view('orders.index', compact(['customer', 'orders']));
    }
}
