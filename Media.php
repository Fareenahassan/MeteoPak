<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'tags',
    ];

    /**
     * Get the tags as an array.
     *
     * @return array
     */
    public function getTagsArrayAttribute()
    {
        return json_decode($this->tags, true) ?? [];
    }

    /**
     * Get the public URL of the media file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }
}