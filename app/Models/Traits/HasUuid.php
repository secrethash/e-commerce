<?php

namespace App\Models\Traits;

use Str;

/**
 * Has UUID
 */
trait TraitName
{
    /**
     * Add Uuid while Creating a Model
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn(self $model) => $model->forceFill([
            'uuid' => Str::uuid(),
        ]));
    }
}
