<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function account()
    {
        $user = Auth::user();
        return view('content.user.account', compact('user'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->paginate(12);
        return view('content.user.orders', compact('orders'));
    }
}
