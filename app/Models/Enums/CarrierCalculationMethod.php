<?php

namespace App\Models\Enums;

enum CarrierCalculationMethod: string {

    case FLAT = 'flat';
    case PERCENTAGE = 'percent';

    public function label(): string
    {
        return match($this)
        {
            static::FLAT => 'Flat',
            static::PERCENTAGE => 'Percent',
        };
    }

    public function identifiers(): string
    {
        return match($this)
        {
            static::FLAT => shopper_currency(),
            static::PERCENTAGE => '%',
        };
    }

    public function formattedCharge($charge): string
    {
        return match($this)
        {
            static::FLAT => price_formatted($charge * 100),
            static::PERCENTAGE => $charge.'%',
        };
    }

    public static function toArray(): array
    {
        $array = [];
        foreach (static::cases() as $case) {
            $array[$case->value] = $case->label();
        }
        return $array;;
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
