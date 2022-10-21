<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopper\Framework\Contracts\ReviewRateable;
use Shopper\Framework\Models\Shop\Product\Product as ShopperProduct;
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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
