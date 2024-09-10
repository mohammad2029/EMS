<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number' => $request->phone_number,
                    'user_image' => $image_name,
                    'countrey' => $request->countrey,
                    'state' => $request->state,
                    'admin_id' => $request->admin_id
                ]);
                return $this->ReturnSuccessMessage('registerd successfully');
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
}
