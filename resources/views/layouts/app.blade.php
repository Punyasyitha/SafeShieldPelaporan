<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="g-sidenav-show bg-gray-100 relative min-h-screen flex flex-col">
    <!-- Ilustrasi di sisi atas -->
    <div class="absolute w-full min-h-[300px] top-0"
        style="background-image: url('{{ asset('assets/images/App_Two.jpg') }}'); background-size: contain; background-position: center; ">
        <span class="absolute inset-0 bg-gradient-to-b from-primary/50 to-transparent"></span>
    </div>
    <!-- Konten Utama -->
    <div class="relative z-10 flex-1 flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navbars.admin.sidebar')

        <!-- Bagian kanan untuk topbar dan konten -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar sejajar dengan sidebar -->
            @include('layouts.navbars.admin.topbar')

            <!-- Konten halaman -->
            <div class="flex-1 bg-transparent overflow-auto p-6 space-y-6 flex flex-col">
                <!-- Padding ditambahkan di sini -->
                <main class="flex-1 p-6 transition-all duration-300">
                    {{ $slot }}
                </main>
                @include('layouts.footers.admin.footer') <!-- Footer ditambahkan di sini -->
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });

        // Toggle Dropdown User
        document.querySelector('[id^=userDropdown]').previousElementSibling.addEventListener('click', function() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        });
    </script>
</body>

</html>
