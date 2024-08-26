<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Organization_section extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
'description',
'countrey',
'state',
'place',
'organization_id',
    ];

    /**
     * Get the user that owns the Organization_section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
