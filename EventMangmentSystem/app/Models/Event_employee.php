<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Event_employee extends Model
{
    use HasFactory;
    protected $fillable =[
        'birth_date',
        'work',
        'event_id',
    ];

    /**
     * Get the user that owns the Event_employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
