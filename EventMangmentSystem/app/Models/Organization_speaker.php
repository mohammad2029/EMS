<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Organization_speaker extends Model
{
    use HasFactory;

    protected $fillable =[
        'speaker_start_date',
'speaker_id',
'organization_id',
    ];


    /**
     * Get the user that owns the Organization_speaker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }


    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
