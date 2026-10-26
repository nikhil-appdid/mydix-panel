<link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link href="
https://cdn.jsdelivr.net/npm/notiflix@3.2.6/dist/notiflix-3.2.6.min.css
" rel="stylesheet">

<style>
    .material-symbols-outlined {
      font-variation-settings:
      'FILL' 0,
      'wght' 400,
      'GRAD' 0,
      'opsz' 48
    }
    </style>
@livewireStyles()
@if (!empty($pageConfigs['has_table']))
    @if ($pageConfigs['has_table'])
        <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}" />
    @endif
@endif
@if (!empty($pageConfigs['has_editor']))
    @if ($pageConfigs['has_editor'])
        <link rel="stylesheet" href="{{ asset('vendors/css/editors/quill/katex.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/css/editors/quill/monokai-sublime.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/css/editors/quill/quill.snow.css') }}">
        <link rel="stylesheet" href="{{ asset('vendors/css/editors/quill/quill.bubble.css') }}">
    @endif
@endif

<link rel="stylesheet" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">

@if (!empty($pageConfigs['has_animation']))
    @if ($pageConfigs['has_animation'])
        <link rel="stylesheet" href="{{ asset('vendors/css/animate/animate.min.css') }}">
    @endif
@endif
@if (!empty($pageConfigs['has_player']))
    @if ($pageConfigs['has_player'])
        <link rel="stylesheet" href="{{ asset('vendors/css/extensions/plyr.min.css') }}">
    @endif
@endif

@if (!empty($pageConfigs['has_chart']))
    @if ($pageConfigs['has_chart'])
        <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
    @endif
@endif
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@vite('resources/sass/base/plugins/extensions/ext-component-toastr.scss')


{{-- Vendor Styles --}}
@yield('vendor-style')
{{-- Theme Styles --}}

@vite('resources/sass/core.scss')

{{-- {!! Helper::applClasses() !!} --}}
@php $configData = Helper::applClasses(); @endphp

{{-- Page Styles --}}
@if ($configData['mainLayoutType'] === 'horizontal')
    @vite('resources/sass/base/core/menu/menu-types/horizontal-menu.scss')
@endif
@vite('resources/sass/base/core/menu/menu-types/vertical-menu.scss')
<!-- @vite('resources/sass/base/core/colors/palette-gradient.scss') -->

{{-- Page Styles --}}
@yield('page-style')

@if (!empty($pageConfigs['has_editor']))
    @if ($pageConfigs['has_editor'])
        @vite('resources/sass/base/plugins/forms/form-quill-editor.scss')
    @endif
@endif

@vite('resources/sass/base/plugins/extensions/ext-component-sweet-alerts.scss')

@if (!empty($pageConfigs['has_player']))
    @if ($pageConfigs['has_player'])
        @vite('resources/sass/base/plugins/extensions/ext-component-media-player.scss')
    @endif
@endif

@if (!empty($pageConfigs['has_chart']))
    @if ($pageConfigs['has_chart'])
        @vite('resources/sass/base/plugins/charts/chart-apex.scss')
    @endif
@endif
@vite('resources/sass/base/plugins/forms/pickers/form-flat-pickr.scss')




{{-- Custom RTL Styles --}}

@if ($configData['direction'] === 'rtl' && isset($configData['direction']))
    @vite('resources/sass/base/custom-rtl.scss')
    @vite('resources/assets/scss/style-rtl.scss')
@endif
@stack('component-style')
{{-- user custom styles --}}
@vite('resources/assets/scss/style.scss')
{{-- Laravel Style --}}
@vite('resources/sass/overrides.scss')
@vite('resources/sass/color-overrides.scss')
<style>
    [x-cloak] {
        display: none !important;
    }

    .table th,
    .table td {
        padding: 0.72rem 0.7rem !important;
    }
    .table td img {
        width: 45px !important;
    }
</style>
