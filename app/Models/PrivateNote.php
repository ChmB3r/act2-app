<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateNote extends Model
{
    protected $primaryKey = 'entry_id';
    public $incrementing = false;
    protected $fillable = ['entry_id', 'rating', 'note'];

    /**
     * Get the tracker entry that owns the private note.
     */
    public function trackerEntry()
    {
        return $this->belongsTo(TrackerEntry::class, 'entry_id');
    }
}
