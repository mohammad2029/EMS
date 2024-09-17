<?php

namespace App\Http\Controllers;

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
                Mail::to($new_user->email)->send(new VerifyEmail($code, now()->addMinutes(60)));

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
                'user_id' => 'required',
                'event_id' => 'required',
            ]);
            $event = Event::where('event_id', $request->event_id)
                ->select('event_id', 'is_done', 'remaining_tickets')
                ->first();
            $user_event = User_Event::where('user_id', $request->user_id)
                ->where('event_id', $request->event_id)
                ->first();
            if ($event->remaining_tickets == 0)
                return $this->ReturnFailMessage('there is no tickests left ');

            if ($user_event)
                return $this->ReturnFailMessage('you are already registerd ');

            if ($event->is_done == 0 && $event->remaining_tickets > 0) {
                $event->update([
                    'remaining_tickets' => $event->remaining_tickets - 1,
                ]);
                User_Event::create([
                    'user_id' => $request->user_id,
                    'event_id' => $request->event_id,
                ]);
                return $this->ReturnSuccessMessage('registerd succ');
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }



    public function send_verification_code(Request $request)
    {

        try {
            $request->validate(['id' => 'required']);
            $user = User::find($request->id);
            $code = rand(1000, 9999);
            $user->verify_code = $code;
            $user->update([
                'verify_code' => $code
            ]);
            Mail::to($user->email)->send(new VerifyEmail($code, now()->addMinutes(60)));
            return $this->ReturnSuccessMessage('code sent succ');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
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
