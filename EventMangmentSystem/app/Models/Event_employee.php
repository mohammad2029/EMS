<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Event_employee extends Model
{
    use HasFactory;
    protected $primaryKey='event_employee_id';
    protected $fillable =[
        'birth_date',
        'work',
        'event_id',
    ];

    /**
     * Get the user that owns the Event_employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function setBirthDateAttribute($value){
        $this->attributes['birth_date']=Carbon::createFromFormat('d-m-Y',$value)->format('Y-m-d');
    }

    public function getBirthDateAttribute(){
        return Carbon::createFromFormat('Y-m-d', $this->attributes['birth_date'])->format('d-m-Y');
    }
}
