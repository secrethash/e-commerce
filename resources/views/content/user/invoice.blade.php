<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Order Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('frontend/assets/css/invoice/modern-normalize.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/invoice/web-base.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/invoice/invoice.css')}}">
</head>

<body>

    <div class="web-container">

        <div class="page-container">
            Page
            <span class="page"></span>
            of
            <span class="pages"></span>
        </div>

        <div class="logo-container">
            <img style="height: 100px" src="{{asset('images/logo.svg')}}">
        </div>

        <table class="invoice-info-container">
            <tr>
                <td rowspan="2" class="client-name">
                    {{ $order->shippingAddress->full_name }}
                </td>
                <td>
                    <h3 style="margin-bottom: 2px;text-decoration: underline;">Shipping Address:</h3>
                    @if($order->shippingAddress->company_name)
                        {{ $order->shippingAddress->company_name }}
                    @else
                        {{ $order->shippingAddress->full_name }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    {{ $order->shippingAddress->street_address }} <br>
                    {{ $order->shippingAddress->city }} - {{ $order->shippingAddress->zipcode }}
                </td>
            </tr>
            <tr>
                <td>
                    Invoice Date: <strong>{{$order->created_at->format('D, d M Y')}}</strong>
                </td>
                <td>
                    @if ($order->shippingAddress->state)
                        {{ $order->shippingAddress->state->name }}
                    @endif
                    <br>{{ $order->shippingAddress->country->name }}
                </td>
            </tr>
            <tr>
                <td>
                    Order No: <strong>#{{$order->number}}</strong>
                </td>
                <td>
                    {{$order->customer->email}}
                </td>
            </tr>
        </table>


        <table class="line-items-container">
            <thead>
                <tr>
                    <th class="heading-quantity">Qty</th>
                    <th class="heading-description">Description</th>
                    <th class="heading-price">Price</th>
                    <th class="heading-subtotal">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{$item->quantity}} x</td>
                        <td>
                            {{$item->name}}<br>
                            <small>SKU: {{$item->sku}}</small>
                        </td>
                        <td class="right">{{price_formatted($item->unit_price_amount)}}</td>
                        <td class="bold">{{price_formatted($item->total)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <table class="line-items-container has-bottom-border">
            <thead>
                <tr>
                    <th>Payment Info</th>
                    <th>Shipping</th>
                    <th>Tax</th>
                    <th>Total {{ $order->isPaid() ? 'Paid' : 'Due' }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="payment-info large">
                        <div>
                            Status:
                            <strong @class([
                                "due" => !$order->isPaid(),
                                "paid" => $order->isPaid(),
                                ])>
                                {{ $order->isPaid() ? 'Paid' : 'Due' }}
                            </strong>
                        </div>
                        <div>
                            {{ $order->paymentMethod->title }}
                        </div>
                    </td>
                    <td>
                        {{shopper_money_format($order->shipping_total)}}
                    </td>
                    <td>
                        {{shopper_money_format($order->tax_total)}}
                    </td>
                    <td @class([
                        "large total",
                        "due" => !$order->isPaid(),
                        "paid" => $order->isPaid(),
                        ])>
                        {{shopper_money_format($order->fullPriceWithShipping() + $order->tax_total)}}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="footer-info">
                <span>{{ shopper_setting('shop_email') }}</span> |
                <span>{{ shopper_setting('shop_phone_number')}}</span> |
                <span>{{ Str::remove(['https', 'http', ':/', '/'], config('app.url')) }}</span>
            </div>
            <div class="footer-thanks">
                <img src="https://github.com/anvilco/html-pdf-invoice-template/raw/main/img/heart.png" alt="heart">
                <span>Thank you!</span>
            </div>
        </div>


    </div>

</body>

</html>
