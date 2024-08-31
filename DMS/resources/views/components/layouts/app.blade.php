<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ Vite::asset('resources/assets/images/favicon.ico') }}">

    <!-- APP Assets Bundles -->
    @vite(['resources/assets/css/theme.css', 'resources/assets/js/theme.js'])
    <title>{{ $title ?? env('APP_NAME') }}</title>
    @livewireStyles
</head>

<body>
    <div id="layout-wrapper">
        <x-layouts.navbar/>
        <x-layouts.sidebar/>
        <div class="main-content">
            {{-- Toast --}}
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <x-layouts.footer/>
    </div>
    @livewireScripts
</body>


</html>
