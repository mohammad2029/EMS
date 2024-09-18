<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationRegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Traits\HttpResponsesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrganizationController extends Controller
{
    use HttpResponsesTrait;

    public function organization_register(OrganizationRegisterRequest $request)
    {

        try {
            $request->validated($request->all());
            $organization = Organization::where('email', $request->email)->first();
            if (!$organization) {
                $image_ext =  $request->file('logo')->getClientOriginalExtension();
                $image_name = time() . '.' . $image_ext;
                $path = 'images/organizations';
                $request->file('logo')->move($path, $image_name);
                $code = rand(1000, 9999);
                $new_organization = Organization::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'name' => $request->name,
                    'logo' => $image_name,
                    'organization_description' => $request->organization_description,
                    'code' => $code,
                    'organization_type' => $request->organization_type,
                    'admin_id' => $request->admin_id,
                ]);
                Mail::to($new_organization->email)->send(new VerifyEmail($code, now()->addMinutes(60)));
                return $this->ReturnSuccessMessage('registerd successfully , verification code sent to your email');
            } else {
                return $this->ReturnFailMessage('email already exist');
            }
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage()
            ]);
        }
    }



    public function organization_login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string'],
                'password' => ['required', 'min:8', 'string']
            ]);
            $organization = Organization::where('email', $request->email)->first();
            if (Auth::guard('organization')->attempt(['email' => $request->email, 'password' => $request->password])) { {
                    $organization->token =  Auth::guard('organization')->attempt(['email' => $request->email, 'password' => $request->password]);

                    return  $this->SuccessWithData('organization', $organization, 'loged in successfully');
                }
            } else {
                return $this->ReturnFailMessage('email and password does not match');
            }
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage()
            ]);
        }
    }



    public function organization_logout(Request $request)
    {

        try {
            if ($request->header('Auth-token')) {
                return  $this->ReturnSuccessMessage('loged out successfully');
            }
            return $this->ReturnFailMessage('you are not authorized', 403);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }






    public function organization_events(Request $request)
    {

        try {
            $events = Event::where('organization_id', $request->organization_id)->get();
            return $this->SuccessWithData('events', $events);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function organization_ended_events(Request $request)
    {

        try {
            $events = Event::where('organization_id', $request->organization_id)
                ->where('is_done', 1)
                ->get();
            return $this->SuccessWithData('events', $events);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function organization_event_show(Request $request)
    {
        try {
            $request->validate(['event_id' => 'required']);
            $event = Event::with(['event_employees', 'event_photos', 'event_sections', 'event_requirments', 'speakers'])
                ->where('event_id', $request->event_id)
                ->first();
            // $event = Event::whereBelongsTo('organization')
            //     ->where('event_id', $request->event_id)
            //     ->first();
            return $this->SuccessWithData('event', $event);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function hello()
    {

        return 'hello';
    }









    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        //
    }
}
