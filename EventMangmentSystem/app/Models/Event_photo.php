<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Event_photo extends Model
{
    use HasFactory;
    protected $primaryKey='event_photo_id';
    protected $fillable =[
        'photo_path',
        'event_id',
    ];

    /**
     * Get the user that owns the Event_photo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
