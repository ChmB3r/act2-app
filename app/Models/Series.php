<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['mal_id', 'title', 'description', 'cover_image', 'total_chapters'];

    /**
     * Get the tracker entries for the series.
     */
    public function trackerEntries()
    {
        return $this->hasMany(TrackerEntry::class);
    }

    /**
     * The genres that belong to the series.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'series_genre');
    }
}
