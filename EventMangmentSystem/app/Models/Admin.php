<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{

    use HasFactory;
    protected $table='admins';
    protected $guard='admin';
    protected $fillable =[
        'admin_id',
'email',
'password'];





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








public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }




}



