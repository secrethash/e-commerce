<?php

namespace App\Models;

use App\Models\Enums\Visibility;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Str;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn(Model $model) => $model->forceFill([
            'uuid' => Str::uuid(),
        ]));
    }

    /**
     * Wishlist Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Wishlist User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * is wishlist shareable?
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function shareable(): Attribute
    {
        return Attribute::make(fn():bool => ($this->visibility !== Visibility::PRIVATE));
    }
}
