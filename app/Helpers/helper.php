<?php

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Shopper\Framework\Models\Shop\Order\Order;

// use NumberFormatter;

if (! function_exists('price_quantity')) {

    function price_quantity(int $cents, int $quantity): int {
        return $cents * $quantity;
    }
}

if (! function_exists('price_quantity_format')) {

    function price_quantity_format(int $price, int $quantity): string {
        return price_formatted(price_quantity($price * 100, $quantity));
    }
}

if (! function_exists('price_formatted')) {

    function price_formatted(int $cents): string {
        $money = new Money($cents, new Currency(shopper_currency()));
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

        return $moneyFormatter->format($money);
    }
}

if (!function_exists('order_number')) {
    function order_number(int $length = 7, int $regenerated = 0) {
        $min = "";
        $max = "";
        for($i = 0; $i < $length; $i++) {
            $min .= "9";
            $max .= "1";
        }

        $generated = rand((int) $min, (int) $max);

        $find = Order::whereNumber($generated)->first();

        if (!$find) {
            return $generated;
        }

        if ($regenerated > 15) {
            order_number($length+1);
        }

        return order_number($length, $regenerated + 1);
    }
}

