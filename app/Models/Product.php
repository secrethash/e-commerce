<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopper\Framework\Contracts\ReviewRateable;
use Shopper\Framework\Models\Shop\Product\Product as ShopperProduct;
use Shopper\Helpers\Price;
use Spatie\MediaLibrary\HasMedia;

class Product extends ShopperProduct implements HasMedia, ReviewRateable
{
    use HasFactory;

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function stars(): Attribute
    {
        return Attribute::get(fn():int  => round($this->ratingPercent()));
    }

    public function starsEmpty(): Attribute
    {
        return Attribute::get(fn():int => (5 - $this->stars));
    }

    public function priceAmount(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    public function oldPriceAmount(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    public function costAmount(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    /**
     * Get the formatted price value.
     */
    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->parent_id) {
            return $this->price_amount
                ? $this->formattedPrice($this->price_amount * 100)
                : ($this->parent->price_amount ? $this->formattedPrice($this->parent->price_amount * 100) : null);
        }

        return $this->price_amount
                ? $this->formattedPrice($this->price_amount * 100)
                : null;
    }

    public function getPriceAttribute(): ?Price
    {
        if (! $this->price_amount) {
            return null;
        }

        return Price::from($this->price_amount * 100);
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
