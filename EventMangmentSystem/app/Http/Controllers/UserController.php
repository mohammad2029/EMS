<?php

namespace App\Http\Controllers;

use App\Events\FreeGiftEvent;
use App\Events\RegisterEvent;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\testMailable;
use App\Mail\VerifyEmail;
use App\Models\Event;
use App\Models\User;
use App\Models\User_Event;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use HttpResponsesTrait;

    public function user_register(UserRegisterRequest $request)
    {

        try {
            $request->validated($request->all());
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $image_ext =  $request->file('user_image')->getClientOriginalExtension();
                $image_name = time() . '.' . $image_ext;
                $path = 'images/users';
                $request->file('user_image')->move($path, $image_name);
                $code = rand(1000, 9999);
                return $this->ReturnSuccessMessage('code sent succ');
                $new_user =  User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number' => $request->phone_number,
                    'user_image' => $image_name,
                    'countrey' => $request->countrey,
                    'state' => $request->state,
                    'code' => $code,
                    'admin_id' => $request->admin_id
                ]);
                RegisterEvent::dispatch($new_user);
                return $this->ReturnSuccessMessage('registerd successfully , code sent to your email');
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


    public function user_login(UserLoginRequest $request)
    {
        try {
            $request->validated($request->all());
            $user = User::where('email', $request->email)->first();
            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) { {
                    $user->token =  Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password]);
                    return  $this->SuccessWithData('user', $user, 'loged in successfully');
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


    public function user_logout(Request $request)
    {

        try {
            if ($request->header('Auth-token')) {

                JWTAuth::setToken($request->header('Auth-token'))->invalidate();
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






    public function user_event_register(Request $request)
    {
        try {

            $request->validate([
                'event_id' => 'required',
            ]);
            $event = Event::where('event_id', $request->event_id)
                ->select('event_id', 'is_done', 'remaining_tickets')
                ->first();
            $user_event = User_Event::where('user_id', Auth::guard('user')->id())
                ->where('event_id', $request->event_id)
                ->first();
            if ($event->remaining_tickets == 0)
                return $this->ReturnFailMessage('there is no tickests left ');

            if ($user_event)
                return $this->ReturnFailMessage('you are already registerd ');

            if ($event->is_done == 0) {
                $event->update([
                    'remaining_tickets' => $event->remaining_tickets - 1,
                ]);
                User_Event::create([
                    'user_id' => Auth::guard('user')->id(),
                    'event_id' => $request->event_id,
                ]);
                $user = User::find(Auth::guard('user')->id());
                if ($user->events()->count() >= 2) {
                    if (($user->events()->count() - (2 * (int)($user->events()->count() / 2))) == 0) {
                        $user->update(['free_events' => $user->free_events + 1]);
                        FreeGiftEvent::dispatch($user);
                        return $this->ReturnSuccessMessage('registerd succ , you got free event check your email for more info');
                    }
                }
                return $this->ReturnSuccessMessage('registerd succ');
            } else return $this->ReturnSuccessMessage('event is already done');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }


    public function show_registerd_events()
    {
        try {

            $user = User::find(Auth::guard('user')->id());
            $events = $user->events()
                ->select(['events.event_id', 'place'])
                ->with(['speakers', 'event_sections', 'event_photos'])
                ->get();
            return $this->SuccessWithData('events', $events);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }








    public function user_event_show(Request $request)
    {
        try {
            $request->validate(['event_id' => 'required']);
            $event = Event::with(['event_photos', 'event_sections',  'speakers'])
                ->where('event_id', $request->event_id)
                ->first();
            return $this->SuccessWithData('event', $event);
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }




    public function use_free_gift(Request $request)
    {
        try {
            $request->validate(['event_id' => 'required']);
            $user = User::find(Auth::guard('user')->id());
            if ($user->free_events > 0) {
                $user->update(['free_events' => $user->free_events - 1]);
                User_Event::create([
                    'event_id' => $request->event_id,
                    'user_id' => Auth::guard('user')->id()
                ]);
                return $this->ReturnSuccessMessage('you used your gift succ');
            }
            return $this->ReturnSuccessMessage('you dont have a free gift');
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function user_rate(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required',
                'rate' => ['required', 'max:5']
            ]);
            $user_event = User_Event::where('event_id', $request->event_id)
                ->where('user_id', Auth::guard('user')->id())
                ->first();
            $user_event->update(['rate' => $request->rate]);
            return $this->ReturnSuccessMessage('thank you for your opinion');
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }





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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }









    public function hello(Request $request)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();
            return 'auth' . $user;
        } catch (\Throwable $e) {

            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
