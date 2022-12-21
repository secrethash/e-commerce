<?php

namespace App\Models;

use App\Models\Enums\CarrierCalculationMethod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CarrierPricing extends Model
{
    use HasFactory;

    protected $table = 'carrier_pricing';

    protected $casts = [
        'method' => CarrierCalculationMethod::class,
    ];

    protected $guarded = ['id'];

    protected $append = ['formatted_amount'];

    public function calculable(): MorphTo
    {
        return $this->morphTo();
    }

    public function carrier(): BelongsTo
    {
        return $this->belongsTo(Carrier::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    public function minimumOrder(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    public function maximumOrder(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }

    public function formattedAmount(): Attribute
    {
        return Attribute::get(
            fn() => price_formatted($this->amount * 100)
        );
    }

    public function formattedMinimumOrder(): Attribute
    {
        return Attribute::get(
            fn() => price_formatted($this->minimum_order * 100)
        );
    }

    public function formattedMaximumOrder(): Attribute
    {
        return Attribute::get(
            fn() => price_formatted($this->maximum_order * 100)
        );
    }
}
