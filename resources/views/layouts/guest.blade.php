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

    <!-- Font Awesome -->
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GtvLyykRPk7y9jHjSh7zS0skTOoaRfgbB2VaZCJoQ0FfDRFHRy6cNOXjmvH87pW3" crossorigin="anonymous">

    <!-- Bootstrap JS (opsional jika pakai komponen JS Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p3t6V1SM2ctEmqebdaFdJrZtHvtrcDKIK1eHIYjSU/EzJ0R6Rna7QfRQjv8e/epM" crossorigin="anonymous">
    </script>
</head>

<body class="g-sidenav-show bg-gray-100 relative min-h-screen flex flex-col">
    <!-- Ilustrasi di sisi atas -->
    <div class="absolute w-full min-h-[300px] top-0"
        style="background-image: url('{{ asset('assets/images/App_Two.jpg') }}'); background-size: contain; background-position: center; ">
        <span class="absolute inset-0 bg-gradient-to-b from-primary/50 to-transparent"></span>
    </div>
    <!-- Konten Utama -->
    <div class="relative z-10 flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.navbars.user.sidebar')

        <!-- Bagian kanan untuk topbar dan konten -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar sejajar dengan sidebar -->
            <div class="lg:pl-[250px] transition-all duration-300">
                @include('layouts.navbars.user.topbar')
            </div>
            <!-- Konten halaman -->
            <div
                class="bg-transparent overflow-auto space-y-6 min-h-screen pr-6 flex flex-col
                transition-all duration-300 pl-4 lg:pl-[280px]">
                <!-- Ubah pl-10 menjadi pl-4 untuk mobile, lg:pl-250px untuk desktop -->
                <main class="transition-all duration-300 flex-grow">
                    {{ $slot }}
                </main>
                @include('layouts.footers.user.footer') <!-- Footer -->
            </div>
        </div>
    </div>


    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            sidebar.classList.toggle('-translate-x-full'); // Toggle sidebar
            content.classList.toggle('lg:pl-[280px]'); // Toggle jarak konten
            content.classList.toggle('lg:pl-4'); // Agar kembali tanpa jarak saat sidebar tertutup
        });

        // Toggle Dropdown User
        document.querySelector('[id^=userDropdown]').previousElementSibling.addEventListener('click', function() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        });
    </script>
</body>

</html>
