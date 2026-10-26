<?php
namespace App\Traits;

use App\Models\Otp;
use App\Models\User;
use App\Services\SmsIntegration;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

trait OtpTrait
{
    public $testingNumbers = [
        8111111111,
        9111111111,
        7111111111,
        7111111112,
        6111111111,
        5111111111,
        4111111111,
        3111111111,
        2111111111,
        1111111111,
    ];

    public $testingOtp = 1234;

    public function send($phone, $signature = null)
    {
        // $this->checkIfUserIsRegistered($phone);

        $otp = random_int(1000, 9999);
        if (! in_array($phone, $this->testingNumbers)) {
            $message = "$signature $otp is your OTP (One Time Password) for logging into the App. For security reasons, do not share the OTP. Regards Team Appdid Infotech LLP.";
            SmsIntegration::sms($message, $phone);
        } else {
            $otp = $this->testingOtp;
        }

        Otp::create([
            "phone"  => $phone,
            "otp"    => $otp,
            "expiry" => Carbon::now()->addMinutes(2),
        ]);
    }

    public function getOtp($phone, $otp)
    {
        return Otp::where(['phone' => $phone, "otp" => $otp, "is_used" => 0])->latest()->first();
    }

    public function otpService($phone, $otp)
    {
        $verifyOtp = $this->getOtp($phone, $otp);
        $this->incorrectOtp($verifyOtp);
        $this->otpExpired($verifyOtp->expiry);
        $this->updateOtp($verifyOtp);
    }

    public function incorrectOtp($verifyOtp)
    {
        if (! $verifyOtp) {
            throw ValidationException::withMessages([
                "invalid_otp" => ['Invalid OTP'],
            ]);
        }
    }

    public function otpExpired($verifyOtp)
    {
        if ($verifyOtp < now()) {
            throw ValidationException::withMessages([
                "otp_expired" => "OTP Expired",
            ]);
        }
    }

    public function updateOtp($verifyOtp)
    {
        $verifyOtp->update([
            "is_used" => 1,
        ]);
    }

    public function getUserType($phone, $device_id)
    {
        $user = $this->getUser($phone);
        if ($user?->name) {
            $type            = "old";
            $user->device_id = $device_id;
            $user->save();
        } else {
            $type = "new";
            if (! $user) {
                $user            = new User();
                $user->phone     = $phone;
                $user->device_id = $device_id;
                $user->save();
            }
        }
        return [$user, $type];
    }

    public function generateToken($data, $type)
    {
        return [
            "otp_verified" => true,
            "token"        => $data->createToken("token")->plainTextToken,
            "type"         => $type,
        ];
    }

    public function getUser($phone)
    {
        return User::where("phone", $phone)->first();
    }
}
