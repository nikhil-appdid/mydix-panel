<?php

use App\Http\Controllers\Api\BasicController;
use Illuminate\Support\Facades\Route;

Route::controller(BasicController::class)->prefix('basic')->group(function () {
    Route::get('business-setting', 'businessSetting');
});
