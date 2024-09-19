<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Event_requirment;
use App\Traits\HttpResponsesTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    use HttpResponsesTrait;
    /**
     * Display a listing of the resource.
     */
    public function all_events()
    {
        $events = Event::with([
            'EventPhotos' => function ($q) {
                $q->select('event_photo_id', 'event_id', 'photo_path');
            },
            'EventEmployees' => function ($q) {
                $q->select('event_employee_id', 'event_id', 'work');
            },
            'speakers' => function ($q) {
                $q->select('speaker_id', 'event_id', 'name');
            }
        ])
            ->where('is_published', 1)
            ->get();
        return $this->SuccessWithData('events', $events, 'events returned successfully');
    }


    public function store(StoreEventRequest $request)
    {
        try {
            $request->validated($request->all());
            $carbon_start_date = Carbon::createFromFormat('d-m-Y', $request->start_date);
            $carbon_end_date = Carbon::createFromFormat('d-m-Y', $request->end_date);
            if ($carbon_end_date->isAfter($carbon_start_date) && $carbon_start_date->greaterThan(Carbon::today())) {
                $carbon_start_date->format('Y-m-d');
                $carbon_end_date->format('Y-m-d');
                Event::create([
                    'event_name' => $request->event_name,
                    'event_description' => $request->event_description,
                    'countrey' => $request->countrey,
                    'state' => $request->state,
                    'street' => $request->street,
                    'place' => $request->place,
                    'event_type' => $request->event_type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'tickets_number' => $request->tickets_number,
                    'remaining_tickets' => $request->tickets_number,
                    'ticket_price' => $request->ticket_price,
                    'organization_id' => $request->organization_id,
                ]);
                return $this->ReturnSuccessMessage('event added succ');
            } else
                return $this->ReturnFailMessage('end date or start date is invalid');
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request)
    {
        try {
            $request->validated($request->all());
            $event = Event::where('event_id', $request->event_id)->first();
            if (Auth::guard('organization')->id() === $event->organization_id) {

                $event->update($request->all());
                return $this->ReturnSuccessMessage('event updated succ');
            }
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }



    public function destroy(Request $request)
    {
        try {
            $event = Event::where('event_id', $request->event_id)->first();
            if (Auth::guard('organization')->id() === $event->organization_id) {
                $event->delete();
                return $this->ReturnSuccessMessage('event deleted succ');
            }
            return $this->ReturnFailMessage('you are not authorized to delete this event', 403);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }



    public function publish_event(Request $request)
    {
        try {
            $request->validate(['event_id' => 'required']);
            $event = Event::find($request->event_id);
            $requirments_count = Event_requirment::where('event_id', $request->event_id)
                ->select('event_id', 'is_done')
                ->get();
            $completed_requirments_count = Event_requirment::where('event_id', $request->event_id)
                ->select('event_id', 'is_done')
                ->where('is_done', 1)
                ->get();

            if ($requirments_count == $completed_requirments_count) {
                $event->update([
                    'is_published' => 1
                ]);
                return $this->ReturnSuccessMessage('published succ');
            } else {
                return $this->ReturnFailMessage('requirments not done yet');
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }


    public function search_throw_event_type(Request $request)
    {
        try {
            $request->validate(['event_type' => Rule::in(['medical', 'cultural', 'sport', 'technical', 'scientific', 'artistic', 'entertaining', 'commercial'])]);
            $events = Event::where('event_type', $request->event_type)->get();
            return $this->SuccessWithData('events', $events);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
