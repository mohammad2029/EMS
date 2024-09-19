<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\HttpResponsesTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    use HttpResponsesTrait;

    public function admin_login(LoginAdminRequest $request)
    {
        try {
            $request->validated($request->all());
            $admin = Admin::where('email', $request->email)->first();
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) { {
                    $admin->token =  Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]);
                    return $this->SuccessWithData('admin', $admin, 'loged in successfully');
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




    public function admin_register(AdminRegisterRequest $request)
    {

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {

            $request->validated($request->all());
            Admin::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return $this->ReturnSuccessMessage('admin registerd successfully');
        }

        return $this->ReturnFailMessage('you are already registered', 200);
    }





    public function admin_logout(Request $request)
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
