{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">

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

{{-- <body class="bg-white min-h-screen">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body> --}}

<body
    class="min-h-screen bg-gradient-to-b from-fuchsia-50 via-white to-purple-50 text-purple-900 antialiased dark:from-purple-900 dark:via-purple-900 dark:to-purple-950 dark:text-gray-100">
    {{-- Background dekoratif --}}
    <div aria-hidden="true" class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-fuchsia-500 blur-3xl opacity-50"></div>
        <div class="absolute top-40 -right-10 h-72 w-72 rounded-full bg-gray-300 blur-3xl opacity-50"></div>
        <div
            class="absolute bottom-0 left-1/2 -translate-x-1/2 h-72 w-[28rem] rounded-full bg-gray-200 blur-3xl opacity-50">
        </div>
    </div>
    <main class="min-h-screen flex items-center py-8 px-4">
        <div class="container mx-auto max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <!-- FORM AUTH SLOT -->
                <div
                    class="w-full max-w-md mx-auto lg:mx-0 rounded-2xl bg-white/90 backdrop-blur-sm p-6 md:p-8 shadow-xl ring-1 ring-black/5 dark:bg-gray-900/70 dark:ring-white/10">
                    {{ $slot }}
                </div>

                <div class="hidden lg:block">
                    <div
                        class="relative min-h-[28rem] rounded-2xl p-10 grid place-items-center text-white shadow-2xl ring-1 ring-white/10 bg-gradient-to-br from-fuchsia-600 to-purple-600 overflow-hidden">
                        <!-- dekorasi glow + animasi -->
                        <span
                            class="pointer-events-none absolute -top-10 -left-10 h-56 w-56 rounded-full bg-white/20 blur-3xl animate-pulse"></span>
                        <span
                            class="pointer-events-none absolute -bottom-12 right-0 h-64 w-64 rounded-full bg-white/10 blur-2xl animate-pulse [animation-duration:2.6s]"></span>
                        <span
                            class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-white/10 to-transparent"></span>

                        <!-- inti animasi: ping waves + orbit berputar + blob melayang -->
                        <div class="relative z-10 mx-auto w-full max-w-sm aspect-square" aria-hidden="true">
                            <!-- gelombang ping -->
                            <span
                                class="absolute inset-0 m-auto h-40 w-40 rounded-full bg-white/25 animate-ping"></span>
                            <span
                                class="absolute inset-0 m-auto h-64 w-64 rounded-full bg-white/15 animate-ping [animation-duration:2.8s]"></span>

                            <!-- blob melayang -->
                            <span
                                class="absolute -top-6 -left-4 h-10 w-10 rounded-full bg-white/25 blur-xl opacity-80 animate-bounce"></span>
                            <span
                                class="absolute -bottom-6 right-6 h-12 w-12 rounded-full bg-white/20 blur-xl opacity-80 animate-bounce [animation-duration:2.2s]"></span>

                            <!-- emblem inti -->
                            <div class="relative grid place-items-center h-full">
                                <div
                                    class="relative h-40 w-40 rounded-full bg-white/15 ring-1 ring-white/30 backdrop-blur-sm grid place-items-center shadow-2xl">
                                    <!-- orbit berputar halus -->
                                    <svg class="absolute h-[115%] w-[115%] -rotate-12 animate-spin [animation-duration:12s] [animation-timing-function:linear] transform-gpu [will-change:transform]"
                                        viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="45" stroke="white"
                                            stroke-opacity="0.35" stroke-width="2" stroke-dasharray="6 10" />
                                    </svg>
                                    <!-- ikon perisai -->
                                    <svg class="h-14 w-14 animate-pulse [animation-duration:1.8s]" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.8"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z" />
                                        <path d="M9 12l2 2 4-4" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- teks kutipan -->
                        <div class="relative z-10 text-center max-w-md space-y-3">
                            <h4 class="text-2xl font-bold leading-relaxed">
                                “Tidak ada alasan untuk kekerasan, tidak ada pembenaran untuk pelecehan. Semua orang
                                berhak merasa aman.”
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>


</html>
