{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />

    <title>SafeShield — PENS</title>
    <meta name="description"
        content="Sistem pelaporan kekerasan seksual yang aman, rahasia, dan mudah digunakan di lingkungan kampus." />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

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

    {{-- NAVBAR --}}
    <header
        class="sticky top-0 z-20 backdrop-blur supports-[backdrop-filter]:bg-white/70 bg-white/60 dark:bg-gray-900/60 border-b border-white/40 dark:border-white/5">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a class="flex items-center gap-2 font-bold text-lg tracking-tight">
                <span class="flex items-baseline gap-0 whitespace-nowrap">
                    <span class="sm:inline">SAFE</span><span class="text-fuchsia-500 font-bold">SHIELD</span>
                </span>
                <img src="{{ asset('assets/images/logoPENS.png') }}" alt="logoPENS"
                    class="w-8 h-8 object-contain ml-3" />
            </a>
        </nav>
    </header>

    <main>
        <!-- HERO -->
        <section class="relative">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-10">
                <div class="max-w-3xl">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">
                        Tata Cara Pengaduan
                    </h1>
                    <p class="mt-4 text-lg/8 text-gray-600 dark:text-gray-300">
                        Halaman ini memberikan pemahaman dan petunjuk berisi langkah-langkah melakukan pengaduan ke
                        website SafeShield
                    </p>
                </div>
            </div>
        </section>

        <!-- GRID SECTIONS -->
        <section class="py-6 md:py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid gap-6 md:grid-cols-2 lg:grid-cols-2">

                <!-- Step 1 -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Cek Kelengkapan Laporan Pengaduan</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Pengaduan dengan data lengkap dan sesuai dengan kriteria pengaduan
                        akan mempercepat proses tindak lanjut atas aduan Anda.
                    </p>
                </article>

                <!-- Step 2 -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-keyboard text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Isi Formulir Pengaduan</h2>
                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">Klik menu "Pengaduan" yang terdapat pada
                        bagian menu. Isi dan
                        lengkapi formulir pengaduan yang telah disediakan.</p>
                </article>

                <!-- Step 3 -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-paper-plane text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Kirim Formulir Pengaduan Anda</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Apabila pengaduan berhasil dikirm, Anda akan memperoleh notifikasi
                        “berhasil” terkirim dan akan diproses.
                    </p>
                </article>

                <!-- Step 4 -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-rectangle-list text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Pantau Pengaduan</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Melalui halaman status pelaporan Anda dapat memantau pengaduan
                        yang sudah Anda kirim berdasarkan notifikasi yang diterima.
                    </p>
                </article>
            </div>
        </section>
    </main>
</body>

</html>
