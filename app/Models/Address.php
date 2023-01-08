<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shopper\Framework\Models\User\Address as ShopperAddress;

class Address extends ShopperAddress
{
    use HasFactory;

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $address) {
            /** @var \Illuminate\Database\Eloquent\Builder $userAddress */
            $userAddress = $address->user->addresses()->where('type', $address->type);
            if ($userAddress->count() >= 1) {
                if ($address->is_default) {
                    $userAddress->update([
                        'is_default' => false,
                    ]);
                }
            } else {
                $address->forceFill([
                    'is_default' => true,
                ]);
            }
        });
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(CountryState::class, 'country_state_id');
    }

    /**
     * Return Address Full Name.
     */
    public function getFullNameAttribute(): ?string
    {
        return $this->last_name
            ? $this->first_name . ' ' . $this->last_name
            : $this->first_name;
    }
}
