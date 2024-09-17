<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Organization;
use App\Models\User;
use App\Traits\HttpResponsesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    use HttpResponsesTrait;
    public function send_verification_code(Request $request)
    {

        try {

            if (Route::currentRouteName() == 'user.send_verification_code') {
                $request->validate(['id' => 'required']);
                $user = User::find($request->id);
                $code = rand(1000, 9999);
                $user->verify_code = $code;
                $user->update([
                    'verify_code' => $code
                ]);
                Mail::to($user->email)->send(new VerifyEmail($code, now()->addMinutes(60)));
                return $this->ReturnSuccessMessage('code sent succ');
            } else {
                $request->validate(['id' => 'required']);
                $org = Organization::find($request->id);
                $code = rand(1000, 9999);
                $org->verify_code = $code;
                $org->update([
                    'verify_code' => $code
                ]);
                Mail::to($org->email)->send(new VerifyEmail($code, now()->addMinutes(60)));
                return $this->ReturnSuccessMessage('code sent succ');
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500
            ]);
        }
    }
}
