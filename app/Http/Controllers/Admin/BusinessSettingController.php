<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $data = BusinessSetting::pluck('value', 'key');
        return view('content.pages.settings.business-settings', compact('data'));
    }

    public function developerSettings()
    {
        $data = BusinessSetting::pluck('value', 'key');
        return view('content.pages.settings.developer-settings', compact('data'));
    }

    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            BusinessSetting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' => $value,
                ]
            );
        }
        return response([
            'header' => 'Updated!',
            'message' => 'Settings Updated Successfully'
        ]);
    }

    public function privacyPolicy()
    {
        $data = BusinessSetting::where('key', 'privacy_policy')->first();
        return view('content.pages.privacy-policy', compact(['data']));
    }

    public function termsAndCondition()
    {
        $data = BusinessSetting::where('key', 'terms_and_condition')->first();
        return view('content.pages.terms-and-condition', compact(['data']));
    }

    public function contactUs()
    {
        $data = BusinessSetting::where('key', 'contact_us')->first();
        return view('content.pages.contact-us', compact(['data']));
    }

    public function aboutUs()
    {
        $data = BusinessSetting::where('key', 'about_us')->first();
        return view('content.pages.about-us', compact(['data']));
    }

}
