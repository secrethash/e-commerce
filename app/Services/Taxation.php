<?php

namespace App\Services;

use App\Models\Tax;
use App\Models\TaxGroup;

class Taxation {

    protected $taxed;

    public function __construct(public int $amount) {}

    public static function make(int $amount): static
    {
        return new static($amount);
    }

    public static function fromTax(Tax $tax, int $amount): int
    {
        return (new static($amount))->calculate($tax) * 100;
    }

    public function processAll(?TaxGroup $group = null): self
    {
        $taxed = 0;

        if (!$group) {
            $group = TaxGroup::default()->first();
        }

        foreach ($group->taxes()->active()->get() as $tax) {
            $taxed += $this->calculate($tax);
        }

        $this->taxed = $taxed;

        return $this;

    }

    public function getTaxed(): int
    {
        return $this->taxed * 100;
    }

    public function calculate(Tax $tax): float
    {
        return ($this->amount * $tax->rate) / 100;
    }
}
