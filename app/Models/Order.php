<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shopper\Framework\Models\Shop\Order\Order as ShopperOrder;
use Shopper\Framework\Models\Shop\Order\OrderStatus;

class Order extends ShopperOrder
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'status',
        'currency',
        'shipping_total',
        'shipping_method',
        'notes',
        'parent_order_id',
        'shipping_address_id',
        'payment_method_id',
        'price_amount',
        'user_id',
        'tax_total',
        'amounts',
    ];

    protected $casts = [
        'amounts' => 'array',
    ];

    // public function fullPriceWithShipping(): int
    // {
    //     return $this->total() + $this->shipping_total + $this->tax_total;
    // }

    public function markAsPaid(): bool
    {
        return $this->update([
            'status' => OrderStatus::PAID,
        ]);
    }
}
