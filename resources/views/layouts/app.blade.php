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

<body class="h-full g-sidenav-show bg-gray-100 relative flex flex-col">

    <!-- Background header -->
    <div class="absolute w-full min-h-[300px] top-0 z-0"
        style="background-image: url('{{ asset('assets/images/gradien-wall.png') }}'); background-size: cover; background-position: center;">
        <span class="absolute inset-0 bg-gradient-to-b from-primary/50 to-transparent"></span>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navbars.admin.sidebar')

        <!-- Main Content -->
        <div id="content" class="flex-1 flex flex-col transition-all duration-300 ml-5">
            <!-- Topbar -->
            <div class="lg:pl-[250px] transition-all duration-300 pl-1">
                @include('layouts.navbars.admin.topbar')
            </div>

            <!-- Page Content -->
            <div
                class="bg-transparent space-y-6 min-h-screen pr-6 flex flex-col pl-4 lg:pl-[280px] transition-all duration-300">
                <main class="flex-grow">
                    <div class="w-full overflow-x-auto">
                        {{ $slot }}
                    </div>
                </main>
                @include('layouts.footers.admin.footer')
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            sidebar?.classList.toggle('-translate-x-full');
            content?.classList.toggle('lg:pl-[280px]');
            content?.classList.toggle('lg:pl-4');
        });

        // Toggle Dropdown User
        const userToggle = document.querySelector('[id^=userDropdown]')?.previousElementSibling;
        const userDropdown = document.getElementById('userDropdown');

        userToggle?.addEventListener('click', function() {
            userDropdown?.classList.toggle('hidden');
        });
    </script>

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
    @endpush

    @stack('scripts')
</body>

</html>
