<?php

namespace App\Models\Enums;

use App\Models\CountryState;
use Illuminate\Support\Fluent;
use Shopper\Framework\Models\System\Country;

enum ShippingRules: string {

    case COUNTRY = 'country';
    case STATE = 'state';
    case PINCODE = 'pincode';
    case FREE = 'free';

    public function label(): string
    {
        return match($this)
        {
            static::COUNTRY => 'Country',
            static::STATE => 'State',
            static::PINCODE => 'Pincode / Zipcode',
            static::FREE => 'Free Shipping',
        };
    }

    public function longLabel($prepend = 'Shipping Rates by'): string
    {
        return match($this)
        {
            static::COUNTRY => $prepend . ' ' . static::COUNTRY->label(),
            static::STATE => $prepend . ' ' . static::STATE->label(),
            static::PINCODE => $prepend . ' ' . static::PINCODE->label(),
            static::FREE => static::FREE->label(),
        };
    }

    public function calculableType(): string
    {
        return match($this)
        {
            static::COUNTRY => Country::class,
            static::STATE => CountryState::class,
            static::PINCODE => '',
            static::FREE => '',
        };
    }

    public function displayColumn(): string
    {
        return match($this)
        {
            static::COUNTRY => 'name',
            static::STATE => 'name',
            static::PINCODE => '',
            static::FREE => '',
        };
    }

    public function keyColumn(): string
    {
        return match($this)
        {
            static::COUNTRY => 'id',
            static::STATE => 'id',
            static::PINCODE => '',
            static::FREE => '',
        };
    }

    public function whereClause(): Fluent
    {
        $value = match($this)
        {
            static::COUNTRY => [],
            static::STATE => [
                'column' => 'country_id',
                'expression' => '',
                'ownerColumn' => 'country_id',
            ],
            static::PINCODE => [],
            static::FREE => [],
        };
        return (new Fluent($value ?? []));
    }

    public static function toArray(): array
    {
        $array = [];
        foreach (static::cases() as $case) {
            $array[$case->value] = $case->label();
        }
        return $array;
    }

    public static function toLongArray(): array
    {
        $array = [];
        foreach (static::cases() as $case) {
            $array[$case->value] = $case->longLabel();
        }
        return $array;
    }

    public static function values(): array
    {
        $array = [];
        foreach (static::cases() as $case) {
            $array[] = $case->value;
        }
        return $array;
    }
}
