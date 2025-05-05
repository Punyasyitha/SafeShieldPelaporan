{{-- resources/views/layouts/guest.blade.php --}}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen">
    <main class="main-content mt-0">
        <section>
            <div class="min-h-screen flex items-center justify-center bg-purple-100 py-4 px-4">
                <div class="container max-w-7xl mx-auto">
                    <div class="flex flex-wrap lg:flex-nowrap justify-center lg:justify-between items-center gap-10">
                        <!-- FORM AUTH SLOT -->
                        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-xl">
                            {{ $slot }}
                        </div>

                        <!-- ILLUSTRATION -->
                        <div
                            class="hidden lg:flex flex-col justify-center items-center w-1/2 h-full relative rounded-xl p-56 overflow-hidden">
                            <div class="absolute inset-0 opacity-30 bg-cover bg-center"
                                style="background-image: url('{{ asset('assets/images/login.png') }}');">
                            </div>
                            <div class="relative z-10 text-center">
                                <h4 class="font-serif text-xl font-bold mb-2">"Tidak ada alasan untuk kekerasan, tidak ada
                                    pembenaran untuk pelecehan. Semua orang berhak merasa aman"</h4>
                                {{-- <p class="text-sm">Kekerasan dan pelecehan, dalam bentuk apapun, tidak pernah bisa
                                    dibenarkan. Setiap individu memiliki hak untuk hidup, belajar, dan bekerja tanpa
                                    rasa takut. Rasa aman bukanlah privilese, tapi hak dasar yang harus dijamin untuk
                                    semua orang. Sudah saatnya kita menciptakan ruang yang lebih aman, penuh empati, dan
                                    bebas dari segala bentuk kekerasan.</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
