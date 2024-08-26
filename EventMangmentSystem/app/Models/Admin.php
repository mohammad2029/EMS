<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    use HasFactory;
    protected $fillable =[
        'admin_id',
'email',
'password'];



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



