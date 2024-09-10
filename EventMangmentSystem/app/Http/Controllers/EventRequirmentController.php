<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequirment;
use App\Http\Requests\UpdateEventRequirment;
use App\Models\Event_requirment;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;

class EventRequirmentController extends Controller
{
    use HttpResponsesTrait;


    public function get_event_requriments(Request $request)
    {
        $event_requirments = Event_requirment::where('event_id', $request->event_id)->get();
        return $this->SuccessWithData('event_requirments', $event_requirments);
    }


    public function store(StoreEventRequirment $request)
    {
        try {
            $request->validated($request->all());
            Event_requirment::create([
                'event_requirment_description' => $request->event_requirment_description,
                'event_id' => $request->event_id
            ]);
            return $this->ReturnSuccessMessage('added succ');
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateEventRequirment $request,)
    {
        try {
            $request->validated($request->all());
            $event_requirment = Event_requirment::where('event_requirment_id', $request->event_requirment_id)->first();
            $event_requirment->update($request->all());
            return $this->ReturnSuccessMessage('updated succ');
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
            $request->validate(['event_requirment_id' => 'required']);
            $event_requirment = Event_requirment::where('event_requirment_id', $request->event_requirment_id)->first();
            $event_requirment->delete();
            return $this->ReturnSuccessMessage('deleted succ');
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function mark_event_requirmant(Request $request)
    {
        try {
            $request->validate(['event_requirment_id' => 'required', 'is_done' => 'required']);
            $event_requirment = Event_requirment::where('event_requirment_id', $request->event_requirment_id)->first();
            $event_requirment->update([
                'is_done' => $request->is_done
            ]);
            return $this->ReturnSuccessMessage('requirment done');
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
                'is_done' => $request->is_done
            ]);
        }
    }
}
