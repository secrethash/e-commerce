<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Shopper\Framework\Models\System\Country as SystemCountry;

class Country extends SystemCountry
{
    use HasFactory;

    protected $table = 'system_countries';

    protected $casts = [
        'is_active' => 'bool',
        'currencies' => 'array',
    ];

    protected $guarded = ['id'];

    protected $fillable = [
        'is_active',
        'name',
        'name_official',
        'cca3',
        'cca2',
        'flag',
        'latitude',
        'longitude',
        'currencies',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function states(): HasMany
    {
        return $this->hasMany(CountryState::class, 'country_id');
    }
}
