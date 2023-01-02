<?php

namespace App\Http\Livewire\Common\Reloads;

use App\Http\Livewire\Common\Reloads\ReloadsElements;

trait ReloadsAfterBoot {

    use ReloadsElements;

    public function booted()
    {
        method_exists(parent::class, 'booted')
            ? parent::booted()
            : null;
        $this->reloadElements();
    }
}
