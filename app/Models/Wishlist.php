<?php

namespace App\Models;

use App\Models\Enums\Visibility;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Str;

class Wishlist extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'bool',
    ];

    protected $guarded = [
        'id'
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        self::bootHasUuids();
        static::created(function(self $model) {
            if ($model->is_default) {
                $model->user->wishlists()
                    ->whereNotIn('id', [$model->id])
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
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

    /**
     * Columns which will contain Unique IDs
     *
     * @return void
     */
    public function uniqueIds()
    {
        return ['uuid'];
    }
}
