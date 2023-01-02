<?php

namespace App\Services;

use App\Services\Cart;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\CarrierPricing;
use App\Models\Cart as CartModel;
use App\Models\CountryState;
use App\Models\Enums\CarrierCalculationMethod;
use App\Models\Enums\ShippingRules;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
// use Shopper\Framework\Models\System\Country;
use App\Models\Country;

final class Shipping
{

    protected int $shipping = 0;
    protected int $charge = 0;

    public function __construct(
        protected Carrier $carrier,
        protected Address $address,
        protected Cart $cart
    ) {}

    public static function make(Carrier $carrier, Address $address, Cart|CartModel $cart): static
    {
        if ($cart instanceof CartModel) {
            $cart = new Cart($cart);
        }
        $make = app(static::class, compact('carrier', 'address', 'cart'));
        return $make->process();
    }

    public function process()
    {
        $this->run($this->carrier->rule_type);
        return $this;
    }

    /**
     * Return a Collection of Shipping Carriers
     *
     * @param \App\Models\Address $address
     * @param Cart $cart
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function get(Address $address, Cart $cart): Collection
    {
        $carriers = Carrier::active()->get();

        $carriers = $carriers->filter(function($carrier) use($address, $cart) {
            $shipping = static::make($carrier, $address, $cart);
            return $shipping->useable();
        });

        return $carriers;
    }

    /**
     * Check if the shipping rule is useable
     *
     * @return boolean
     */
    public function useable(): bool
    {
        $rule = $this->run($this->carrier->rule_type);
        return $rule !== FALSE;
    }

    public function getCharge(): int
    {
        return $this->charge;
    }

    public function getShipping(): int
    {
        return $this->shipping;
    }

    /**
     * Run the Calculation for the Shipping rules
     *
     *
     * @param \App\Models\Enums\ShippingRules $rule
     * @return bool
     */
    protected function run(ShippingRules $rule): bool|int
    {
        $function = camel_case('rule '.$rule->value.' shipping');
        return $this->call($function);
    }

    /**
     * Call a function
     *
     * @param string $function
     * @param mixed ...$args
     * @return mixed
     */
    protected function call(string $function, ...$args)
    {
        if (!method_exists($this, $function)) {
            throw new \Exception("No Such function: {$function} found");
        }

        return call_user_func([$this, $function], $args);
        // return $this->{$function}($vars);
    }

    /**
     * Shipping rule for Free Shipping
     *
     * @deprecated 1.1.0
     * @return boolean|integer
     */
    private function ruleFreeShipping(): bool|int
    {
        $carrier = $this->carrier;
        $subtotal = $this->cart->subtotal($this->cart->cart);

        if ($carrier->rule_type->freeable()) {
            return false;
        }

        $pricing = $carrier->pricing();

        if ($pricing->count() >= 1) {
            $pricing->where('minimum_order', '<=', $subtotal)
                ->orWhere('maximum_order', '>=', $subtotal);
            if ($pricing->count() >= 1) {
                // return $this->calculate($pricing->first(), $subtotal)->charge;
                return $this->calculateFlat(0, $subtotal)->getCharge();
            }
        }

        return false;
        // return $this->calculateFlat(0, $subtotal)->charge;
    }

    /**
     * Shipping rule for Free Shipping
     *
     * @return boolean|integer
     */
    private function ruleFreeByStateShipping(): bool|int
    {
        $carrier = $this->carrier;
        $address = $this->address;
        $subtotal = $this->cart->subtotal($this->cart->cart);

        if (
            is_null($address->country_state_id) OR
            !$carrier->country OR
            $carrier->country_id != $address->country_id OR
            !$carrier->rule_type->freeable()
        ) {
            return false;
        }

        /** @var \App\Models\CarrierPricing $pricing */
        $pricing = $carrier->pricing()->whereHasMorph(
            'calculable',
            [CountryState::class],
            function (Builder $query) use($address) {
                $query->where('id', $address->country_state_id);
            }
        );

        if ($pricing->count() >= 1) {
            $pricing->where('minimum_order', '<=', $subtotal)
                ->orWhere('maximum_order', '>=', $subtotal);
            if ($pricing->count() >= 1) {
                // return $this->calculate($pricing->first(), $subtotal)->charge;
                return $this->calculateFlat(0, $subtotal)->getCharge();
            }
        }

        // return $this->calculateFlat(0, $subtotal)->charge;
        return false;
    }

    /**
     * Shipping rule for Free Shipping
     *
     * @return boolean|integer
     */
    private function ruleFreeByCountryShipping(): bool|int
    {
        $carrier = $this->carrier;
        $address = $this->address;
        $subtotal = $this->cart->subtotal($this->cart->cart);

        if (!$carrier->rule_type->freeable()) {
            return false;
        }

        /** @var \App\Models\CarrierPricing $pricing */
        $pricing = $carrier->pricing()->whereHasMorph(
            'calculable',
            [Country::class],
            function (Builder $query) use($address) {
                $query->where('id', $address->country_id);
            }
        );

        if ($pricing->count() >= 1) {
            $pricing->where('minimum_order', '<=', $subtotal)
                ->orWhere('maximum_order', '>=', $subtotal);
            if ($pricing->count() >= 1) {
                // return $this->calculate($pricing->first(), $subtotal)->charge;
                return $this->calculateFlat(0, $subtotal)->getCharge();
            }
        }

        // return $this->calculateFlat(0, $subtotal)->charge;
        return false;
    }

    /**
     * Shipping rule for Country Shipping
     *
     * @return boolean|integer
     */
    private function ruleCountryShipping(): bool|int
    {
        $carrier = $this->carrier;
        $address = $this->address;
        $subtotal = $this->cart->subtotal($this->cart->cart);

        if(is_null($address->country_id)) {
            return false;
        }

        /** @var \App\Models\CarrierPricing $pricing */
        $pricing = $carrier->pricing()->whereHasMorph(
            'calculable',
            [Country::class],
            function (Builder $query) use($address) {
                $query->where('id', $address->country_id);
            }
        );

        if ($pricing->count() >= 1) {
            $pricing->where('minimum_order', '<=', $subtotal)
                ->orWhere('maximum_order', '>=', $subtotal);
            if ($pricing->count() >= 1) {
                return $this->calculate($pricing->first(), $subtotal)->getCharge();
            }
        }

        if ($carrier->limited_to_pricing) {
            return false;
        }

        return $this->calculateFlat($carrier->shipping_amount * 100, $subtotal)->getCharge();

    }

    /**
     * Shipping rule for State Shipping
     *
     * @return boolean|integer
     */
    private function ruleStateShipping(): bool|int
    {
        // return 0;
        $carrier = $this->carrier;
        $address = $this->address;
        $subtotal = $this->cart->subtotal($this->cart->cart);

        if (
            is_null($address->country_state_id) OR
            !$carrier->country OR
            $carrier->country_id != $address->country_id
        ) {
            return false;
        }

        /** @var \App\Models\CarrierPricing */
        $pricing = $carrier->pricing()->whereHasMorph(
            'calculable',
            [CountryState::class],
            function (Builder $query) use($address) {
                $query->where('id', $address->country_state_id);
            }
        );

        if ($pricing->count() >= 1) {
            $pricing->where('minimum_order', '<=', $subtotal)
                ->orWhere('maximum_order', '>=', $subtotal);
            if ($pricing->count() >= 1) {
                return $this->calculate($pricing->first(), $subtotal)->getCharge();
            }
        }

        if ($carrier->limited_to_pricing) {
            return false;
        }

        return $this->calculateFlat($carrier->shipping_amount * 100, $subtotal)->getCharge();
    }

    /**
     * Calculate Shipping Charge
     *
     * @param \App\Models\CarrierPricing $price
     * @param integer $amount
     * @return \App\Services\Shipping
     */
    protected function calculate(CarrierPricing $price, int $amount): self
    {
        $function = camel_case('calculate '.$price->method->value);
        // return $this->call($function, $price->amount, $amount);
        return call_user_func([$this, $function], ($price->amount * 100), $amount);
    }

    private function calculateFlat (int $rate, int $amount): self
    {
        $this->shipping = $rate + $amount;
        $this->charge = $rate;
        return $this;
    }

    private function calculatePercent (int $rate, int $amount): self
    {
        $charge = $this->charge = (($amount * ($rate / 100)) / 100);
        $this->shipping = $amount + $charge;
        return $this;
    }

}
