<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];

    /**
     * The series that belong to the genre.
     */
    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_genre');
    }
}
