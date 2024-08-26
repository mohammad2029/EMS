<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class User_Event extends Model
{
    use HasFactory;

    protected $filable=[
        'rate',
'event_id',
'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
