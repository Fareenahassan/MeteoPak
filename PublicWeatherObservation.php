<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicWeatherObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_name',
        'personal_phone',
        'personal_email',
        'latitude',
        'longitude',
        'location_city',
        'location_state',
        'time_zone',
        'event_date',
        'event_time',
        'weather_types',
        'damages',
        'event_description',
        'media_files',
        'status'
    ];

    protected $casts = [
        'weather_types' => 'array',
        'damages' => 'array',
        'media_files' => 'array',
        'event_date' => 'date',
    ];
}
