<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Speaker extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'speaker_id',
        'speaker_contact_email',
        'event_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }


    /**
     * Get all of the comments for the Speaker
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function speaker_experience(): HasMany
    {
        return $this->hasMany(Speaker_experience::class);
    }



    public function organization_speakers(): HasMany
    {
        return $this->hasMany(Organization_speaker::class);
    }
}