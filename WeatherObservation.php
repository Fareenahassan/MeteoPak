<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherObservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'personal_number',
        'designation',
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
        'status', // Status can be: pending, approved, archived, flagged
        'flag_reason'
    ];

    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'weather_types' => 'array',
        'damages' => 'array',
        'media_files' => 'array',
        'event_date' => 'date',
    ];

    /**
     * Get the user that owns the weather observation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 