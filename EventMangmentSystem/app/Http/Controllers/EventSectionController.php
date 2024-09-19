<?php

namespace App\Http\Controllers;

use App\Models\Event_section;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventSectionController extends Controller
{
    use HttpResponsesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => ['required', 'string'],
                'start_time' => ['required'],
                'day_time' => ['required', Rule::in(['AM', 'BM'])],
                'end_time' => ['required'],
                'event_id' => ['required'],
            ]);

            Event_section::create([
                'description' => $request->description,
                'start_time' => $request->start_time,
                'day_time' => $request->day_time,
                'end_time' => $request->end_time,
                'event_id' => $request->event_id
            ]);
            return $this->ReturnSuccessMessage('added succ');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event_section $event_section) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event_section $event_section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            $request->validate([
                'event_section_id' => 'required'
            ]);

            $event_section = Event_section::where('event_section_id', $request->event_section_id)->first();
            $event_section->update($request->all());
            return $this->ReturnSuccessMessage('updated succ');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'event_section_id' => 'required'
            ]);

            $event_section = Event_section::where('event_section_id', $request->event_section_id)->first();
            $event_section->delete();
            return $this->ReturnSuccessMessage('deleted succ');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }
}
