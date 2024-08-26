<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable =[
        'organization_id',
'name',
'logo',
'organization_description',
'organization_type',
'admin_id',
    ];


    /**
     * Get the user that owns the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }


    public function organization_sections(): HasMany
    {
        return $this->hasMany(Organization_section::class);
    }



    public function organization_speaker(): HasMany
    {
        return $this->hasMany(Organization_speaker::class);
    }
}
