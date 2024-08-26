<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Speaker_experience extends Model
{
    use HasFactory;
    protected $fillable =[
        'speaker_experience_name',
'speaker_experience_year',
'speaker_id',
    ];

    /**
     * Get the user that owns the Speaker_experience
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }


}
