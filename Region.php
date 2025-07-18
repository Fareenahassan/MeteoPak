<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the stations for the region.
     */
    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    /**
     * Get the users for the region.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}