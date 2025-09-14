<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="no-referrer-when-downgrade">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GtvLyykRPk7y9jHjSh7zS0skTOoaRfgbB2VaZCJoQ0FfDRFHRy6cNOXjmvH87pW3" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p3t6V1SM2ctEmqebdaFdJrZtHvtrcDKIK1eHIYjSU/EzJ0R6Rna7QfRQjv8e/epM" crossorigin="anonymous" defer>
    </script>

    @stack('styles')
</head>

{{-- <body class="h-full g-sidenav-show bg-gray-100 relative flex flex-col">
    <!-- Background header -->
    <div class="absolute w-full min-h-[300px] top-0 z-0"
        style="background-image: url('{{ asset('assets/images/gradien-wall.png') }}'); background-size: cover; background-position: center;">
        <span class="absolute inset-0 bg-gradient-to-b from-primary/50 to-transparent"></span>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navbars.admin.sidebar')

        <!-- Main Content -->
        <div id="content" class="flex-1 flex flex-col transition-all duration-300 ">
            <!-- Topbar -->
            <div>
                @include('layouts.navbars.admin.topbar')
            </div>

            <!-- Page Content -->
            <div class="bg-transparent space-y-6 min-h-screen pr-6 flex flex-col pl-5 lg:ml-[280px] transition-all duration-300">
                <main class="flex-grow">
                    <div class="w-full overflow-x-auto">
                        {{ $slot }}
                    </div>
                </main>
                @include('layouts.footers.admin.footer')
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush

    @stack('scripts')
</body> --}}

<body class="min-h-screen bg-gradient-to-b from-violet-50 via-white to-fuchsia-50 relative flex flex-col text-gray-900">
    <div aria-hidden="true" class="absolute inset-x-0 top-0 h-[320px] -z-0 pointer-events-none">
        <!-- soft vertical fade -->
        <div
            class="absolute inset-0 bg-gradient-to-b from-fuchsia-100/80 via-pink-50/60 to-transparent dark:from-purple-900/50">
        </div>
        <!-- glow blobs (lebih terang) -->
        <div class="absolute -top-24 -left-24 h-[360px] w-[360px] rounded-full bg-fuchsia-300/35 blur-3xl"></div>
        <div class="absolute top-12 right-0 h-[300px] w-[300px] rounded-full bg-violet-300/30 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 h-40 w-[600px] rounded-full bg-pink-200/40 blur-3xl">
        </div>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navbars.admin.sidebar')

        <!-- Main Content -->
        <div id="content" class="flex-1 flex flex-col transition-all duration-300">
            <!-- Topbar -->
            <div>
                @include('layouts.navbars.admin.topbar')
            </div>

            <!-- Page Content -->
            <div class="bg-transparent space-y-6 min-h-screen pr-6 pl-5 lg:ml-[280px] transition-all duration-300">
                <main class="flex-grow">
                    <div class="w-full overflow-x-auto">
                        {{ $slot }}
                    </div>
                </main>
                @include('layouts.footers.admin.footer')
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush
    @stack('scripts')
</body>


</html>
