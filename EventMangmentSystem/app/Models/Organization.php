<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Organization extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $primaryKey = 'organization_id';
    protected $table = 'organizations';
    protected $fillable = [
        'email',
        'password',
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




    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    public function OrganizationSections(): HasMany
    {
        return $this->hasMany(Organization_section::class, 'organization_id');
    }



    public function OrganizationSpeaker(): HasMany
    {
        return $this->hasMany(Organization_speaker::class, 'organization_id');
    }






    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
