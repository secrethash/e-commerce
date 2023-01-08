<?php

namespace App\Http\Controllers\Shop\Payments;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Services\Cart;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Fluent;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{

    public function process($order, $token, $payment)
    {
        try {
            $order = Order::findOrFail(decrypt($order));
            $clientSecret = decrypt($token);
            $payment = decrypt($payment);
        } catch (DecryptException $e) {
            abort(404);
        }

        $amounts = new Fluent($order->amounts ?? []);
        return view('content.shop.order.payments.stripe', compact('order', 'clientSecret', 'amounts', 'payment'));
    }

    public function capture($order, Request $request)
    {
        try {
            /** @var \App\Models\Order */
            $order = Order::findOrFail(decrypt($order));
        } catch (DecryptException $e) {
            abort(404);
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $stripe = PaymentIntent::retrieve($request->get('payment_intent'));
        // dd($stripe);
        if ($stripe->status !== PaymentIntent::STATUS_SUCCEEDED) {
            return back();
        }

        //? 5. Send Mails
        Mail::to($order->customer)->send(new OrderConfirmed($order, new Fluent($order->amounts)));

        //? 6. Clear Cart
        Cart::empty(Cart::fetch());

        //? 7. Update Order
        $order->markAsPaid();

        //? 8. Redirect
        return redirect()->route('shop.checkout.success', encrypt($order->number));
    }
}
