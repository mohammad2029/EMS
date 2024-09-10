<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventEmployeeRequest;
use App\Http\Requests\updateEventEmployeeRequest;
use App\Models\Event_employee;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventEmployeeController extends Controller
{
    use HttpResponsesTrait;

    public function all()
    {
        $event_employees = Event_employee::all();
        return $this->SuccessWithData('event_employees', $event_employees);
    }



    public function store(StoreEventEmployeeRequest $request)
    {
        try {
            $request->validated($request->all());
            Event_employee::create([
                'birth_date' => $request->birth_date,
                'work' => $request->work,
                'event_id' => $request->event_id,
            ]);
            return $this->ReturnSuccessMessage('employee added succ');
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $event_employee = Event_employee::where('event_employee_id', $request->event_employee_id)->first();
            return $this->SuccessWithData('event_employee', $event_employee);
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
    public function update(updateEventEmployeeRequest $request)
    {
        try {
            $event_employee = Event_employee::where('event_employee_id', $request->event_employee_id)->first();
            $event_employee->update($request->all());
            return $this->ReturnSuccessMessage('updated succ');
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $event_employee = Event_employee::where('event_employee_id', $request->event_employee_id)->first();
            $event_employee->delete();
            return $this->ReturnSuccessMessage('deleted succ');
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
