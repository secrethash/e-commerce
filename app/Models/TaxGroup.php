<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxGroup extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_groups';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'bool',
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

        static::created(function(self $model) {
            if ($model->is_default) {
                $basename = class_basename($model);
                $basename::whereNotIn('id', [$model->id])
                    ->update(['is_default' => false]);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function taxes(): HasMany
    {
        return $this->hasMany(Tax::class);
    }
}
