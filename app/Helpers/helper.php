<?php

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
// use NumberFormatter;

if (! function_exists('price_quantity')) {

    function price_quantity(int $cents, int $quantity): int {
        return $cents * $quantity;
    }
}

if (! function_exists('price_quantity_format')) {

    function price_quantity_format(int $cents, int $quantity): string {
        return price_formatted(price_quantity($cents, $quantity));
    }
}

if (! function_exists('price_formatted')) {

    function price_formatted(int $price): string {
        $money = new Money($price, new Currency(shopper_currency()));
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

