<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Traits\ResponseTrait;

class BasicController extends Controller
{
    use ResponseTrait;

    public function businessSetting()
    {
        $businessSettings = BusinessSetting::all();
        return $this->success(data: $businessSettings);
    }
}
