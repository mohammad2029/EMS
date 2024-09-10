<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Event_section extends Model
{
    use HasFactory;
    protected $primaryKey = 'event_section_id';

    protected $fillable = [
        'description',
        'start_time',
        'day_time',
        'end_time',
        'event_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}