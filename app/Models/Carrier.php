<?php

namespace App\Models;

use App\Models\Enums\ShippingRules;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Shopper\Framework\Models\Shop\Carrier as ShopCarrier;
use Shopper\Framework\Models\System\Country;

class Carrier extends ShopCarrier
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'rule_type' => ShippingRules::class,
        'is_enabled' => 'bool',
        'is_store_pickup' => 'bool',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saving(function(self $model) {
            $model->forceFill([
                'slug' => slugify_model(
                    self::class,
                    "{$model->name}",
                    $model->slug
                ),
            ]);
        });
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(CarrierPricing::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_enabled', true);
    }
}
