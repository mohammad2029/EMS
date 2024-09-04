<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\HttpResponsesTrait;
use Exception;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    use HttpResponsesTrait;

public function admin_login(LoginAdminRequest $request){
$request->validated($request->all());
$admin=Admin::where('email',$request->email)->first();
if($admin)
{
    if(Hash::check($request->password,$admin->password))
    {
        $token=Auth::guard('admin') ->attempt(['email'=>$request->email,'password'=>$request->password]);
        return  response()->json([
            'token'=>$token,
            'code'=>'200',
            'email'=>$request->email,
            'pass'=>$admin->password,
            'password_check'=>Hash::check($request->password,$admin->password)
        ]);

    }

    else
    {
        return  response()->json([
            'code'=>'403',
        ]);
    }
}

// return $user;
// return auth('admin')->attempt([]);
// return $password;

}
public function admin_register(AdminRegisterRequest $request){

    $admin=Admin::where('email',$request->email)->first();
    if(!$admin)
    {

        $request->validated($request->all());
        Admin::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
    return $this->ReturnSuccessMessage('admin registerd successfully');

    }

    return $this->ReturnFailMessage('you are already registered',200);
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
