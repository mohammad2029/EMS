<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    protected $primaryKey = 'event_id';
    protected $fillable = [
        'remaining_tickets',
        'is_published',
        'event_name',
        'event_description',
        'countrey',
        'state',
        'street',
        'place',
        'event_type',
        'start_date',
        'end_date',
        'tickets_number',
        'ticket_price',
        'is_done',
        'organization_id',
        'admin_id',
    ];
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    /**
     * Get all of the comments for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function UserEvents(): HasMany
    {
        return $this->hasMany(User_Event::class, 'event_id');
    }



    public function EventEmployees(): HasMany
    {
        return $this->hasMany(Event_employee::class, 'event_id');
    }




    public function EventPhotos(): HasMany
    {
        return $this->hasMany(Event_photo::class, 'event_id');
    }


    public function EventSections(): HasMany
    {
        return $this->hasMany(User_Event::class, 'event_id');
    }



    public function EventRequirments(): HasMany
    {
        return $this->hasMany(Event_requirment::class, 'event_id');
    }



    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class, 'event_id');
    }



    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_users', 'event_id', 'user_id');
    }



    public static function eventtype(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtolower($value),
            set: fn($value) => strtolower($value)
        );
    }


    // public function setStartDateAttribute($value)
    // {
    //     $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    // }
    // public function setEndDateAttribute($value)
    // {
    //     $this->attributes['end_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    // }

    public function getStartDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['start_date'])->format('d-m-Y');
    }
    public function getEndDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['end_date'])->format('d-m-Y');
    }
}
