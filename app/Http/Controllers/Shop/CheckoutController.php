<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\Cart as CartService;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Shopper\Framework\Models\Shop\Order\Order;

class CheckoutController extends Controller
{
    /**
     * Display the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        return view('content.shop.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(?Cart $cart = null)
    {
        $cart = CartService::fetch();
        // $cart = $cart ?? CartService::fetch();

        if(CartService::isEmpty($cart)) {
            return redirect()->route('shop.cart')->with('notice', [
                [
                    'type' => 'danger',
                    'heading' => 'Cart is Empty!',
                    'message' => 'No Products in your cart. Please add some products to your cart then proceed to checkout.',
                ]
            ]);
        }

        return view('content.shop.checkout', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function success($orderNumber)
    {
        $order = null;
        try {
            $order = decrypt($orderNumber);
        } catch (DecryptException $e) {
            abort('404');
        }

        $order = Order::where('number', $order)->first();

        return view('content.shop.order.success', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
