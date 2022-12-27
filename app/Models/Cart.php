<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;
use App\Models\Carrier;
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
        static::deleting(fn(self $model) => $model->products()->detach());
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
     * Cart Shipping
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Carrier::class, 'carrier_id');
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
