<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackerEntry extends Model
{
    protected $fillable = ['user_id', 'series_id', 'status', 'last_read_chapter'];

    /**
     * Get the user that owns the tracker entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the series that is being tracked.
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get the private note associated with the tracker entry.
     */
    public function privateNote()
    {
        return $this->hasOne(PrivateNote::class, 'entry_id');
    }
}
