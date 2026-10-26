<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsIntegration
{

    //Message Format should be passed in the $message variable.
    // $message = "$request->app_signature $otp is your OTP (One Time Password) for logging into the App. For security reasons, do not share the OTP. Regards Team Appdid Infotech LLP.";

    public static function sms($message, $number, $projectName = 'Appdid')
    {
        $data = array(
            'api_id' => env('MESSAGE_API_KEY'),
            'api_password' => env('MESSAGE_API_PASSWORD'),
            'sms_type' => "Appdid Universal OTP",
            'sms_encoding' => "1",
            'sender' => env('MESSAGE_API_SENDER_ID'),
            'number' => $number,
            'message' => $message,
            'template_id' => "170770"
        );
        $data_string = json_encode($data);
        $response =  HTTP::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://sms.appdidsms.in/api/send_sms', json_decode($data_string, true));
        self::trackOtp($response, $projectName, env('MESSAGE_API_SENDER_ID'));
        return $response;
    }

    private static function trackOtp($response, $projectName)
    {
        try {
            $response = json_decode($response);
            $balance = $response->balance;
            $sender = $response->message->sender;
            $trackingUrl = "https://otp-tracking.appdid.com/api/v1/track";
            Http::post($trackingUrl, [
                'project_name' => $projectName,
                'pending_balance' => $balance,
                'sender' => $sender,
            ]);
        } catch (\Throwable $th) {
            \Log::info($th);
        }
    }


    // Old DlT Via Text Local.

      // public static function sms($message, $phoneNumber, $projectName = "Admin Panel Template")
    // {
    //     if ($projectName == "Admin Panel Template") {
    //         return throw ValidationException::withMessages([
    //             'change_dlt_project_name' => "Change the project name in SmsIntegration.php file inisde the 'sms' function and after that delete this condition",
    //         ]);
    //     }

    //     $apiKey = urlencode('hSujJlRSq2I-XEo8CBoacqW8di87eBZKo8O6vniWOf');
    //     $numbers = array($phoneNumber);
    //     $sender = urlencode('APPDID');
    //     $numbers = implode(',', $numbers);
    //     $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
    //     $ch = curl_init('https://api.textlocal.in/send/');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);
    //     self::trackOtp($response, $projectName);
    //     return json_decode($response);
    // }

}
