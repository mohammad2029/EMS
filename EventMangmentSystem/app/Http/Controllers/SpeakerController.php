<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    use HttpResponsesTrait;

    public function index(Request $request)
    {
        $speakers = Speaker::where('event_id', $request->event_id)->get();
        return $this->SuccessWithData('speakers', $speakers);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required',
                'name' => 'required',
                'speaker_contact_email' => 'required'
            ]);
            Speaker::create([
                'event_id' => $request->event_id,
                'name' => $request->name,
                'speaker_contact_email' => $request->speaker_contact_email
            ]);
            return $this->ReturnSuccessMessage('added succ');
        } catch (\Throwable $e) {
            return response()->json([
                'meesage' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $request->validate([
                'speaker_id' => 'required',
            ]);
            $speaker = Speaker::find($request->speaker_id);

            return $this->SuccessWithData('speaker', $speaker, 'this is speaker');
        } catch (\Throwable $e) {
            return response()->json([
                'meesage' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'speaker_id' => 'required',
            ]);
            $speaker = Speaker::find($request->speaker_id);
            $speaker->update($request->all());
            return $this->ReturnSuccessMessage('updated succ');
        } catch (\Throwable $e) {
            return response()->json([
                'meesage' => $e->getMessage(),
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
                'speaker_id' => 'required',
            ]);
            $speaker = Speaker::find($request->speaker_id);
            $speaker->delete();
            return $this->ReturnSuccessMessage('deleted succ');
        } catch (\Throwable $e) {
            return response()->json([
                'meesage' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }
}
