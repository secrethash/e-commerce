<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shopper\Framework\Models\Shop\Order\Order as ShopperOrder;
use Shopper\Framework\Models\Shop\Order\OrderStatus;
// use App\Models\Enums\OrderStatus;

class Order extends ShopperOrder
{
    use HasFactory;
}
