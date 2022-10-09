<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shopper\Framework\Models\Shop\Product\Brand as ProductBrand;

class Brand extends ProductBrand
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'website',
        'description',
        'position',
        'seo_title',
        'seo_description',
        'is_enabled',
        'aftermarket',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'aftermarket' => 'boolean',
    ];

    public function scopeAftermarket(Builder $query): Builder
    {
        return $query->where('aftermarket', true);
    }
    public function scopeNotAftermarket(Builder $query): Builder
    {
        return $query->where('aftermarket', false);
    }
}
