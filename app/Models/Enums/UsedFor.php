<?php

namespace App\Models\Enums;

enum UsedFor: string {

    case SLIDER = 'slider';
    case OFFER_HOMEPAGE_SOLO = 'offer_homepage_solo';
    case OFFER_HOMEPAGE_DUO = 'offer_homepage_duo';

    public function text(): string
    {
        return match($this)
        {
            static::SLIDER => 'Slider',
            static::OFFER_HOMEPAGE_SOLO => 'Homepage Offer Solo',
            static::OFFER_HOMEPAGE_DUO => 'Homepage Offer Duo',
        };
    }

    public static function toArray(): array
    {
        $array = [];
        foreach (static::cases() as $case) {
            $array[$case->value] = $case->text();
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
