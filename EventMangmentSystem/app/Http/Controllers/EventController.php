<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Traits\HttpResponsesTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use HttpResponsesTrait;
    /**
     * Display a listing of the resource.
     */
    public function all_events()
    {
        return $this->SuccessWithData('events',Event::all(),'events returned successfully');
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
                try{
                    $request->validated($request->all());
                    $carbon_start_date=Carbon::createFromFormat('d-m-Y',$request->start_date);
                    $carbon_end_date=Carbon::createFromFormat('d-m-Y',$request->end_date);
                    if($carbon_end_date->isAfter($carbon_start_date)&& $carbon_start_date->greaterThan(Carbon::today()))
                    {
                        $carbon_start_date->format('Y-m-d');
                        $carbon_end_date->format('Y-m-d');
                        Event::create([
    'event_name'=>$request->event_name,
    'event_description'=>$request->event_description,
    'countrey'=>$request->countrey,
    'state'=>$request->state,
    'street'=>$request->street,
    'place'=>$request->place,
    'event_type'=>$request->event_type,
    'start_date'=>$request->start_date,
    'end_date'=>$request->end_date,
    'tickets_number'=>$request->tickets_number,
    'ticket_price'=>$request->ticket_price,
    'organization_id'=>$request->organization_id,
                        ]);
    return $this->ReturnSuccessMessage('event added succ');

                    }
                    else
                    return $this->ReturnFailMessage('end date or start date is invalid');
                }
                catch (\Throwable $e) {

                    return response()->json([
                        'code' => '500',
                        'error'=>$e->getMessage(),
                    ]);
                }

    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request)
    {
        try{
            $request->validated($request->all());
            $event=Event::where('event_id',$request->event_id)->first();
            $event->update($request->all());
            return $this->ReturnSuccessMessage('event updated succ');

        } catch (\Throwable $e) {

                    return response()->json([
                        'code' => '500',
                        'error'=>$e->getMessage(),
                    ]);
        }
    }



    public function destroy(Request $request)
    {
            try{
                $event=Event::where('event_id',$request->event_id)->first();
                if(!empty($event)){
                    $event->delete();
                    return $this->ReturnSuccessMessage('event deleted succ');
                }
                return $this->ReturnFailMessage('event not found',404);
            }catch (\Throwable $e) {

                return response()->json([
                    'code' => '500',
                    'error'=>$e->getMessage(),
                ]);
    }

    }

    public function get_event(Request $request)
    {
            try{
                $event=Event::where('event_id',$request->event_id)->first();
                return response()->json([
                    $event
                ]);
                // if(!empty($event)){
                //     return $this->SuccessWithData('event',$event,'event deleted succ');
                // }
                // return $this->ReturnFailMessage('event not found',404);
            }catch (\Throwable $e) {

                return response()->json([
                    'code' => '500',
                    'error'=>$e->getMessage(),
                ]);
    }

    }










}
