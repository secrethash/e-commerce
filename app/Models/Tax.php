<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tax extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'bool',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::boot();

        static::creating(function(self $model) {
            $model->forceFill([
                'slug' => slugify_model(
                    self::class,
                    "{$model->name}"
                ),
            ]);
        });
        static::updating(function(self $model) {
            $model->forceFill([
                'slug' => slugify_model(
                    self::class,
                    "{$model->name}",
                    $model->slug
                ),
            ]);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(TaxGroup::class);
    }

    public function rate(): Attribute
    {
        return Attribute::make(
            fn($value) => $value / 100,
            fn($value) => $value * 100
        );
    }
}
