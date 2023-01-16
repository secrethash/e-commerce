<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Orders;
use Auth;
use Illuminate\Http\Request;
use Response;
use Shopper\Framework\Models\Shop\Order\Order;
use Str;

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
        $invoiceUrl = Orders::make($order)->generateSignedDownloadInvoice(30);
        return view('content.user.order-details', compact('order', 'invoiceUrl'));
    }

    public function orderInvoice($order)
    {
        $order = Order::whereNumber($order)->first();
        return view('content.user.invoice', compact('order'));
    }

    public function orderDownloadInvoice($order)
    {
        $order = Order::whereNumber($order)->first();
        $file = Orders::make($order)->pdfInvoice();
        $filename = Str::snake(config('app.name')."-{$order->number}").'.pdf';
        return response()->download($file, $filename);
    }
}
