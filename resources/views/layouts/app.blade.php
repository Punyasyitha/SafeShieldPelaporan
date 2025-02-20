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

<body class="g-sidenav-show bg-gray-100 relative min-h-screen">
    <!-- Latar belakang satu warna -->
    <div class="absolute inset-0 z-0 bg-primary"></div>

    <!-- Konten Utama -->
    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar -->
            @include('layouts.navbars.sidebar')

        <!-- Bagian kanan untuk topbar dan konten -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar sejajar dengan sidebar -->
            <div class="w-full h-16 bg-gradient-to-r from-purple-100 to-purple-400 shadow z-10">
                @include('layouts.navbars.topbar')
            </div>

            <!-- Konten halaman -->
            <div class="flex-1 bg-transparent overflow-auto p-6 space-y-6"> <!-- Padding ditambahkan di sini -->
                @isset($header)
                    <header class="bg-yellow-200 shadow rounded-xl p-8"> <!-- Styling disesuaikan seperti gambar -->
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}

                            @isset($subheader)
                                <div class="text-gray-700 text-base">
                                    {{ $subheader }}
                                </div>
                            @endisset
                        </div>
                    </header>
                @endisset

                <main class="p-6 transition-all duration-300">
                    {{ $slot }}
                </main>
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
