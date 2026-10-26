<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\OtpTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use OtpTrait, ResponseTrait;
    public function sendOtp(Request $request)
    {
        $request->validate([
            "phone" => "required|digits:10",
            "app_signature" => "nullable|string",
        ]);
        $this->send($request->phone, $request->app_signature);
        return $this->success(message: "Otp Send Successfully");
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            "phone" => "required|digits:10",
            "otp" => "required|digits:4",
            'device_id' => 'nullable',
        ]);

        $this->otpService($request->phone, $request->otp);
        $type = $this->getUserType($request->phone, $request->device_id);
        $user = $type[0];
        $type = $type[1];
        $token = $this->generateToken($user, $type);
        return $this->success(message: "OTP Verified", extras: $token);
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email",
        ]);
        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $this->success(message: "Registered Successfully");
    }

    public function profile()
    {
        $user_id = auth()->user()->id;
        $data = User::find($user_id);
        return $this->success(data: $data);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success(message: "Logged Out");
    }
}
