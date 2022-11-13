<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Shopper\Framework\Models\Shop\Product\Product;
use App\Models\Product;
use Str;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'uuid',
    ];

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
     * Cart Products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity']);
    }

    /**
     * Cart User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Is a guest cart?
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isGuest(): Attribute
    {
        return Attribute::make(fn():bool => $this->user === null);
    }
}
