<?php

namespace App\Models\Enums;

use App\Models\CountryState;
use Illuminate\Support\Fluent;
use Shopper\Framework\Models\System\Country;

enum ShippingRules: string {

    case COUNTRY = 'country';
    case STATE = 'state';
    case PINCODE = 'pincode';
    // case FREE = 'free';
    case FREEBYCOUNTRY = 'free-by-country';
    case FREEBYSTATE = 'free-by-state';

    public function label(): string
    {
        return match($this)
        {
            static::COUNTRY => 'Country',
            static::STATE => 'State',
            static::PINCODE => 'Pincode / Zipcode',
            // static::FREE => 'Free Shipping',
            static::FREEBYCOUNTRY => 'Free Shipping (by country)',
            static::FREEBYSTATE => 'Free Shipping (by state)',
        };
    }

    public function longLabel($prepend = 'Shipping Rates by'): string
    {
        return match($this)
        {
            static::COUNTRY => $prepend . ' ' . static::COUNTRY->label(),
            static::STATE => $prepend . ' ' . static::STATE->label(),
            static::PINCODE => $prepend . ' ' . static::PINCODE->label(),
            // static::FREE => static::FREE->label(),
            static::FREEBYCOUNTRY => static::FREEBYCOUNTRY->label(),
            static::FREEBYSTATE => static::FREEBYSTATE->label(),
        };
    }

    public function calculableType(): string
    {
        return match($this)
        {
            static::COUNTRY => Country::class,
            static::STATE => CountryState::class,
            static::PINCODE => '',
            // static::FREE => '',
            static::FREEBYCOUNTRY => Country::class,
            static::FREEBYSTATE => CountryState::class,
        };
    }

    public function displayColumn(): string
    {
        return match($this)
        {
            static::COUNTRY => 'name',
            static::STATE => 'name',
            static::PINCODE => '',
            // static::FREE => '',
            static::FREEBYCOUNTRY => 'name',
            static::FREEBYSTATE => 'name',
        };
    }

    public function keyColumn(): string
    {
        return match($this)
        {
            static::COUNTRY => 'id',
            static::STATE => 'id',
            static::PINCODE => '',
            // static::FREE => '',
            static::FREEBYCOUNTRY => 'id',
            static::FREEBYSTATE => 'id',
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
            // static::FREE => [],
            static::FREEBYCOUNTRY => [],
            static::FREEBYSTATE => [
                'column' => 'country_id',
                'expression' => '',
                'ownerColumn' => 'country_id',
            ],
        };
        return (new Fluent($value ?? []));
    }

    public function freeable(): bool
    {
        return match($this)
        {
            static::COUNTRY => false,
            static::STATE => false,
            static::PINCODE => false,
            // static::FREE => true,
            static::FREEBYCOUNTRY => true,
            static::FREEBYSTATE => true,
        };
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
