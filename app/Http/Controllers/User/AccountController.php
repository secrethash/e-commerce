<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Shopper\Framework\Models\Shop\Order\Order;

class AccountController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        return view('content.user.account', compact('user'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(12);
        return view('content.user.orders', compact('orders'));
    }

    public function orderDetails($order)
    {
        $order = Order::where('number', $order)->first();
        return view('content.user.order-details', compact('order'));
    }
}
