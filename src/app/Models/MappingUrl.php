<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MappingUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'long_url',
        'shortened_url',
        'click_count',
        'expired_at'
    ];

    public function analyticsUrls(): HasMany
    {
        return $this->hasMany(AnalyticsUrl::class);
    }
}
