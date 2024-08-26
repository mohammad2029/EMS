<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable =[
        'event_id',
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

    public function user_events(): HasMany
    {
        return $this->hasMany(User_Event::class);
    }



    public function event_employees(): HasMany
    {
        return $this->hasMany(Event_employee::class);
    }




    public function event_photos(): HasMany
    {
        return $this->hasMany(Event_photo::class);
    }


    public function event_sections(): HasMany
    {
        return $this->hasMany(User_Event::class);

    }






    public function event_requirments(): HasMany
    {
        return $this->hasMany(Event_requirment::class);

    }



    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class);

    }



}
