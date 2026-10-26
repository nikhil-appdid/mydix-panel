<?php


namespace App\Traits;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Response;

trait ResponseTrait
{
    public function success($data = null, $message = null, $code = 200, $success = true, $extras = [])
    {
        return response([
            "success" => $success,
            "message" => $message,
            "data" => $data,
            ...$extras
        ], $code);
    }

    public function error($message = null, $code = null, $success = false)
    {
        return response([
            "success" => $success,
            "message" => $message,
        ], $code);
    }
}
