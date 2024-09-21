<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class User_Event extends Model
{
    use HasFactory;
    protected $table = 'event_users';
    protected $primaryKey = 'user_event_id';
    protected $fillable = [
        'user_id',
        'rate',
        'event_id',
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