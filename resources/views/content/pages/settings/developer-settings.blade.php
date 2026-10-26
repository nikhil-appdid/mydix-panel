@extends('layouts/contentLayoutMaster')

@section('title', 'Business Settings')
@section('page-style')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .dropdown-menu {
            transform: scale(1) !important;
        }
    </style>
@endsection

@section('content')
    <x-card>
        <div style="font-size: 17px; color: red !important;" class="alert alert-danger d-flex py-2 justify-content-center align-items-center text-center" role="danger">
            <strong>Warning:</strong>&nbsp;Modifying developer settings may impact critical app functionalities.
        </div>
        <x-form id="add-ground" method="POST" :reset="0" class="" :route="route('admin.business-settings.store')">
             <x-divider text="User" />
            {{-- Android --}}
            <div class="col-md-3">
                <x-input value="{{ $data['app_version_android'] ?? '' }}" name="app_version_android"
                    label="App Version Android" />
            </div>
            <div class="col-md-3">
                <x-input value="{{ $data['app_download_android'] ?? '' }}" name="app_download_android"
                    label="App Download Link Android" />
            </div>
            <div class="col-md-2 my-auto">
                <div class="custom-control custom-control-success custom-switch">
                    <input value="0" type="hidden" name="force_update_for_android">
                    <input value="1" name="force_update_for_android" type="checkbox"
                        @if ($data['force_update_for_android'] ?? '' == 1) checked @endif class="custom-control-input"
                        id="switch-force-update-for-android">
                    <label class="custom-control-label" for="switch-force-update-for-android">Force-Update Android</label>
                </div>
            </div>
            <div class="col-md-2 my-auto">
                <div class="custom-control custom-control-success custom-switch">
                    <input value="0" type="hidden" name="maintenance_mode_for_android">
                    <input value="1" name="maintenance_mode_for_android" type="checkbox"
                        @if ($data['maintenance_mode_for_android'] ?? '' == 1) checked @endif class="custom-control-input"
                        id="switch-maintenance-mode-for-android">
                    <label class="custom-control-label" for="switch-maintenance-mode-for-android">Maintenance Mode
                        Android</label>
                </div>
            </div>
            <div class="col-md-2 my-auto">
                <div class="custom-control custom-control-success custom-switch">
                    <input value="0" type="hidden" name="production_mode_for_android">
                    <input value="1" name="production_mode_for_android" type="checkbox"
                        @if ($data['production_mode_for_android'] ?? '' == 1) checked @endif class="custom-control-input"
                        id="switch-production-mode-for-android">
                    <label class="custom-control-label" for="switch-production-mode-for-android">Production Mode
                        Android</label>
                </div>
            </div>

            {{-- IOS --}}
            <div class="col-12 mt-2">
                <div class="row">
                    <div class="col-md-3">
                        <x-input :required="false" value="{{ $data['app_version_ios'] ?? '' }}" name="app_version_ios"
                            label="App Version IOS" />
                    </div>
                    <div class="col-md-3">
                        <x-input :required="false" value="{{ $data['app_download_ios'] ?? '' }}" name="app_download_ios"
                            label="App Download Link IOS" />
                    </div>
                    <div class="col-md-2 my-auto">
                        <div class="custom-control custom-control-success custom-switch">
                            <input value="0" type="hidden" name="force_update_for_ios">
                            <input value="1" name="force_update_for_ios" type="checkbox"
                                @if ($data['force_update_for_ios'] ?? '' == 1) checked @endif class="custom-control-input"
                                id="switch-force-update-for-ios">
                            <label class="custom-control-label" for="switch-force-update-for-ios">Force-Update
                                IOS</label>
                        </div>
                    </div>
                    <div class="col-md-2 my-auto">
                        <div class="custom-control custom-control-success custom-switch">
                            <input value="0" type="hidden" name="maintenance_mode_for_ios">
                            <input value="1" name="maintenance_mode_for_ios" type="checkbox"
                                @if ($data['maintenance_mode_for_ios'] ?? '' == 1) checked @endif class="custom-control-input"
                                id="switch-maintenance-mode-for-ios">
                            <label class="custom-control-label" for="switch-maintenance-mode-for-ios">Maintenance Mode
                                IOS</label>
                        </div>
                    </div>
                    <div class="col-md-2 my-auto">
                        <div class="custom-control custom-control-success custom-switch">
                            <input value="0" type="hidden" name="production_mode_for_ios">
                            <input value="1" name="production_mode_for_ios" type="checkbox"
                                @if ($data['production_mode_for_ios'] ?? '' == 1) checked @endif class="custom-control-input"
                                id="switch-production-mode-for-ios">
                            <label class="custom-control-label" for="switch-production-mode-for-ios">Production Mode
                                IOS</label>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </x-card>
@endsection
@section('page-script')
    <script>
        $(function() {
            fullEditor_about_us.root.innerHTML =
                @if ($data['about_us'] ?? '' != '')
                    `{!! $data['about_us'] ?? '' !!}`
                @endif
            fullEditor_contact_us.root.innerHTML =
                @if ($data['contact_us'] ?? '' != '')
                    `{!! $data['contact_us'] ?? '' !!}`
                @endif
            fullEditor_privacy_policy.root.innerHTML =
                `{!! $data['privacy_policy'] ?? '' !!}`
            fullEditor_terms_and_condition.root.innerHTML =
                `{!! $data['terms_and_condition'] ?? '' !!}`
        }) 
    </script>
@endsection
