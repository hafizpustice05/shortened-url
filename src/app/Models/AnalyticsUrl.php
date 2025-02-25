<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsUrl extends Model
{
    use HasFactory;
    protected $fillable = [
        "mapping_url_id",
        "visitor",
        "country",
        "city",
        "region",
        "visited_at",
        "coordinates"
    ];
}
