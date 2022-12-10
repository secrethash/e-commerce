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
        return [
            static::SLIDER->value => static::SLIDER->text(),
            static::OFFER_HOMEPAGE_SOLO->value => static::OFFER_HOMEPAGE_SOLO->text(),
            static::OFFER_HOMEPAGE_DUO->value => static::OFFER_HOMEPAGE_DUO->text(),
        ];
    }
}
