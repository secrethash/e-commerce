<?php

namespace App\Http\Controllers\Shop\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class StripeController extends Controller
{

    public function process($order, $token)
    {
        try {
            $order = Order::where('number', decrypt($order))->first();
            $clientSecret = decrypt($token);
        } catch (DecryptException $e) {
            abort(404);
        }

        return view('content.shop.order.payments.stripe', []);
    }
}
