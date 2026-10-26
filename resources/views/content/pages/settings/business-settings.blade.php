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
        <x-form id="add-ground" method="POST" :reset="0" class="" :route="route('admin.business-settings.store')">
            <div class="col-md-12 mt-3">
                <label for="about_us">About Us</label>
                <span onclick="window.location.href='/about-us'" class="badge badge-primary cursor-pointer">view</span></label>
                <x-editor name="about_us" />
            </div>
            <div class="col-md-12 mt-3">
                <label for="contact_us">Contact Us</label>
                <span onclick="window.location.href='/contact-us'" class="badge badge-primary cursor-pointer">view</span></label>
                <x-editor name="contact_us" />
            </div>
            <div class="col-md-12 mt-3">
                <label for="privacy_policy">Privacy Policy</label>
                <span onclick="window.location.href='/privacy-policy'" class="badge badge-primary cursor-pointer">view</span></label>
                <x-editor name="privacy_policy" />
            </div>
            <div class="col-md-12 mt-3">
                <label for="terms_and_condition">Terms and Conditions</label>
                <span onclick="window.location.href='/terms-and-condition'" class="badge badge-primary cursor-pointer">view</span></label>
                <x-editor name="terms_and_condition" />
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
