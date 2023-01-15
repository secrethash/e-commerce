@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card my-4">
            <div class="card-body">
                <div class="row card-text">
                    <div class="col-12 col-lg-4">
                        <h6 class="card-title">Delivery Address</h6>
                        <p>
                            {{ $order->shippingAddress->full_name }}<br>
                            @if($order->shippingAddress->company_name)
                                {{ $order->shippingAddress->company_name }}<br>
                            @endif
                            {{ $order->shippingAddress->street_address }}<br>
                            {{ $order->shippingAddress->zipcode }} {{ $order->shippingAddress->city }}<br>
                            {{ $order->shippingAddress->country->name }}<br>
                            @if($order->shippingAddress->phone_number)
                                <span>{{ $order->shippingAddress->phone_number }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col d-none d-lg-block text-center">
                        <div class="vr h-100"></div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <h6 class="card-title text-center d-flex align-items-center justify-content-center">
                            Amount
                            @if ($order->isPaid())
                                <span class="badge bg-success rounded-pill ms-3">Paid</span>
                            @else
                                <span class="badge bg-danger rounded-pill ms-3">Due</span>
                            @endif
                        </h6>
                        <div class="d-flex justify-content-between">
                            <span>Sub-total</span>
                            <strong class="text-dark">{{$order->total}}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <strong class="text-dark">{{shopper_money_format($order->shipping_total)}}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tax</span>
                            <strong class="text-dark">{{shopper_money_format($order->tax_total)}}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bolder">Total</span>
                            <strong class="text-success">{{shopper_money_format($order->fullPriceWithShipping() + $order->tax_total)}}</strong>
                        </div>
                    </div>
                    <div class="col d-none d-lg-block text-center">
                        <div class="vr h-100"></div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <h6 class="card-title text-center">Actions</h6>
                        <button type="button" class="btn btn-outline-primary rounded-0 w-100">
                            <x-ri-file-download-fill width="18" />
                            Download Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-2">
            <div class="card-body">
                <h4 class="card-title mb-0">Order Journey</h4>
                <span class="card-subtitle">Track your order journey</span>
                <div class="card-text">
                    <div class="timeline">
                        <div class="events">
                            <ol>
                                <ul>
                                    <li>
                                        @if ($order->status === $orderStatus::REGISTER)
                                            <a href="#0" class="selected">{{$orderStatus::values()[$orderStatus::REGISTER]}}</a>
                                        @elseif (
                                            $order->status === $orderStatus::SHIPPED OR
                                            $order->status === $orderStatus::DELIVERY OR
                                            $order->status === $orderStatus::COMPLETED
                                        )
                                            <span class="selected">{{$orderStatus::values()[$orderStatus::REGISTER]}}</span>
                                        @else
                                            <span>{{$orderStatus::values()[$orderStatus::REGISTER]}}</span>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($order->status === $orderStatus::SHIPPED)
                                            <a href="#0" class="selected">{{$orderStatus::values()[$orderStatus::SHIPPED]}}</a>
                                        @elseif (
                                            $order->status === $orderStatus::DELIVERY OR
                                            $order->status === $orderStatus::COMPLETED
                                        )
                                            <span class="selected">{{$orderStatus::values()[$orderStatus::SHIPPED]}}</span>
                                        @else
                                            <span>{{$orderStatus::values()[$orderStatus::SHIPPED]}}</span>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($order->status === $orderStatus::DELIVERY)
                                            <a href="#0" class="selected">{{$orderStatus::values()[$orderStatus::DELIVERY]}}</a>
                                        @elseif ($order->status === $orderStatus::COMPLETED)
                                            <span class="selected">{{$orderStatus::values()[$orderStatus::DELIVERY]}}</span>
                                        @else
                                            <span>{{$orderStatus::values()[$orderStatus::DELIVERY]}}</span>
                                        @endif
                                    </li>
                                    <li>
                                        @if ($order->status === $orderStatus::COMPLETED)
                                            <span class="selected">{{$orderStatus::values()[$orderStatus::COMPLETED]}}</span>
                                        @else
                                            <span>{{$orderStatus::values()[$orderStatus::COMPLETED]}}</span>
                                        @endif
                                    </li>
                                </ul>
                            </ol>
                        </div>
                    </div>

                    <h6 class="mx-md-4 mt-5 mb-2 lead text-decoration-underline" style="text-decoration-color: var(--bs-primary) !important;">
                        Order Items:
                    </h6>
                    <div class="table-responsive mx-md-4">
                        <table class="table
                        table-hover
                        table-borderless
                        align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr.</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="fw-bolder text-center">{{$loop->index +1}}</td>
                                            <td scope="row">
                                                {{$item->name}}<br>
                                                <small class="text-muted">{{$item->sku}}</small>
                                            </td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{price_formatted($item->total)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
