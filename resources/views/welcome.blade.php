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

            {{-- <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        @php
                            $role = auth()->user()->role ?? null;
                            $dashboardUrl = $role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                        @endphp
                        <a href="{{ $dashboardUrl }}"
                            class="inline-flex items-center rounded-full bg-gradient-to-r from-fuchsia-600 to-purple-600 px-4 py-2 text-sm font-semibold text-white shadow hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50">Ke
                            Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold hover:bg-gray-100 dark:hover:bg-fuchsia-500 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/40">Masuk</a>
                    @endauth
                @endif
            </div> --}}
        </nav>
    </header>

    {{-- HERO --}}
    <section id="hero" class="relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 md:pt-16 pb-16 md:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Laporkan Tindakan<br />
                        Kekerasan Seksual<br />
                        di <span class="relative inline-block">
                            <span
                                class="absolute -inset-1 -skew-y-1 rounded-xl bg-gradient-to-r from-gray-500/20 to-purple-500/20"></span>
                            <span
                                class="relative bg-clip-text text-transparent bg-gradient-to-r from-fuchsia-600 to-purple-700">Kampus</span>
                        </span><br />
                        Bersama SAFESHIELD
                    </h1>

                    <p class="mt-6 text-lg/8 text-gray-600 dark:text-gray-300 max-w-2xl">
                        SafeShield akan memberikan pelayanan dalam bentuk form pelaporan dan
                        wawasan tetang Satgas PPKPT. Satgas PPKPT akan menindaklanjuti laporan
                        sesuai Permendikbudristek No. 55/2024.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                @php
                                    $role = auth()->user()->role;
                                    $dashboardUrl =
                                        $role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                                @endphp
                                <a href="{{ $dashboardUrl }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-fuchsia-600 to-purple-600 px-6 py-3 text-white font-semibold shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 12h13" />
                                        <path d="m10 7 5 5-5 5" />
                                    </svg>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-fuchsia-600 to-purple-600 px-6 py-3 text-white font-semibold shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v4" />
                                        <path d="M10 14 21 3" />
                                        <path d="M21 10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10" />
                                    </svg>
                                    Login SAFESHIELD
                                </a>
                            @endauth
                        @endif
                        <a href="#features"
                            class="inline-flex items-center gap-2 rounded-full px-6 py-3 font-semibold ring-1 ring-gray-300/80 dark:ring-white/20 hover:bg-gray-50 dark:hover:bg-gray-800">
                            Pelajari Sistem
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-3 max-w-md gap-4 text-center">
                        <div
                            class="rounded-2xl bg-white/70 dark:bg-white/5 p-4 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
                            <div class="text-2xl font-bold">Aman</div>
                            <div class="text-xs text-gray-200">Identitas terlindungi</div>
                        </div>
                        <div
                            class="rounded-2xl bg-white/70 dark:bg-white/5 p-4 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
                            <div class="text-2xl font-bold">Sigap</div>
                            <div class="text-xs text-gray-200">Tindak lanjut cepat</div>
                        </div>
                        <div
                            class="rounded-2xl bg-white/70 dark:bg-white/5 p-4 shadow-sm ring-1 ring-black/5 dark:ring-white/10">
                            <div class="text-2xl font-bold">Terbuka</div>
                            <div class="text-xs text-gray-200">Progres terpantau</div>
                        </div>
                    </div>
                </div>

                {{-- Ilustrasi / kartu info --}}
                <div class="lg:col-span-5">
                    <div class="relative">
                        <!-- Animated Illustration (pure Tailwind utilities) -->
                        <div class="mb-6" aria-hidden="true">
                            <div class="relative mx-auto w-full max-w-xs aspect-square">
                                <!-- Pulsing waves -->
                                <span
                                    class="absolute inset-0 m-auto h-40 w-40 rounded-full bg-fuchsia-400/30 animate-ping"></span>
                                <span
                                    class="absolute inset-0 m-auto h-64 w-64 rounded-full bg-purple-400/20 animate-ping [animation-duration:2.5s]"></span>
                                <!-- Floating blobs -->
                                <span
                                    class="absolute -top-4 -left-6 h-10 w-10 rounded-full bg-fuchsia-300 blur-xl opacity-70 animate-bounce"></span>
                                <span
                                    class="absolute -bottom-6 right-4 h-12 w-12 rounded-full bg-purple-300 blur-xl opacity-70 animate-bounce [animation-duration:2s]"></span>
                                <!-- Core shield -->
                                <div class="relative z-10 grid place-items-center h-full">
                                    <div
                                        class="relative h-40 w-40 rounded-full bg-gradient-to-br from-fuchsia-600 to-purple-600 text-white ring-1 ring-white/20 shadow-2xl grid place-items-center">
                                        <!-- Rotating orbit -->
                                        <svg class="absolute h-[115%] w-[115%] -rotate-12 animate-spin [animation-duration:12s] [animation-timing-function:linear] transform-gpu [will-change:transform]"
                                            viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="50" cy="50" r="45" stroke="white"
                                                stroke-opacity="0.25" stroke-width="2" stroke-dasharray="6 10" />
                                        </svg>
                                        <!-- Shield icon -->
                                        <svg class="h-14 w-14 animate-pulse [animation-duration:1.8s]"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z" />
                                            <path d="M9 12l2 2 4-4" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section id="features" class="md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl md:text-6xl font-extrabold tracking-tight">Mengapa SafeShield?</h2>
                <p class="mt-3 text-gray-600 dark:text-gray-300">Didesain untuk keamanan, kecepatan, dan transparansi
                    proses pelaporan.</p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ url('/regulasi') }}" aria-label="Regulasi Resmi PPKPT"
                    class="group block rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center transition group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-300">
                        <i class= "fa-solid fa-scale-balanced text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Regulasi Resmi PPKPT</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Salinan Permendikbudristek No. 55 Tahun
                        2024.</p>
                </a>

                <a href="{{ url('/edukasi-kekerasan') }}" aria-label="Buka halaman Edukasi Kekerasan"
                    class="group block rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center transition group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-300">
                        <i class="fa-solid fa-person-burst text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Bentuk Kekerasan</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Edukasi bentuk kekerasan khusunya
                        kekerasan seksual.</p>
                </a>

                <a href="{{ url('/tata-cara-pengaduan') }}" aria-label="Buka halaman Tata Cara"
                    class="group block rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center transition group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-300">
                        <i class="fa-solid fa-stairs text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Tata Cara Pengaduan</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Langkah-langkah pengaduan melalui website
                        SafeShield.</p>
                </a>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-14 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl md:text-6xl font-extrabold tracking-tight">FAQs</h2>
                <p class="mt-3 text-gray-600 dark:text-gray-300">Daftar pertanyaan seputar SafeShield.</p>
            </div>

            <div class="mt-10 max-w-3xl mx-auto space-y-4">
                <details
                    class="group rounded-2xl bg-white/80 dark:bg-gray-900/60 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none text-gray-900 dark:text-gray-100 hover:bg-white/90 rounded-2xl dark:hover:bg-white/5">
                        <span class="font-semibold">Apa saja fitur yang ada pada website ini?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="p-4 border-t border-black/5 dark:border-white/10 text-sm text-gray-600 dark:text-gray-300">
                        Website ini memiliki empat fitur utama diantaranya:<br>
                        <strong>1. Beranda:</strong> Artikel terbaru dari Satgas PPKS PENS.<br>
                        <strong>2. Materi:</strong> Modul pembelajaran<br>
                        <strong>3. Pengaduan:</strong> Formulir pelaporan kasus kekerasan/pelecehan seksual.<br>
                        <strong>4. Progress Pengaduan:</strong> Notifikasi status pelaporan.
                    </div>
                </details>

                <details
                    class="group rounded-2xl bg-white/80 dark:bg-gray-900/60 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none text-gray-900 dark:text-gray-100 hover:bg-white/70 rounded-2xl dark:hover:bg-white/5">
                        <span class="font-semibold">Bagaimana pengguna bisa mendapatkan edukasi modul PPKS?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="p-4 border-t border-black/5 dark:border-white/10 text-sm text-gray-600 dark:text-gray-300">
                        Pengguna wajib login terlebih dahulu. Setelah login, pilih menu Materi pada sidebar. Terdapat
                        empat modul pembelajaran yang harus diselesaikan berurutan untuk memberikan pemahaman PPKS dan
                        menumbuhkan sikap anti kekerasan seksual.
                    </div>
                </details>

                <details
                    class="group rounded-2xl bg-white/80 dark:bg-gray-900/60 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none text-gray-900 dark:text-gray-100 hover:bg-white/70 rounded-2xl dark:hover:bg-white/5">
                        <span class="font-semibold"> Bagaimana cara melaporkan tindakan kekerasan atau pelecehan
                            seksual di PENS?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="p-4 border-t border-black/5 dark:border-white/10 text-sm text-gray-600 dark:text-gray-300">
                        Login terlebih dahulu, lalu buka menu Pengaduan. Isi formulir dengan:<br>
                        <strong>1. Identitas:</strong> Nama lengkap, nomor telepon, email.<br>
                        <strong>2. Detail Pengaduan:</strong> Nama terlapor, tempat & tanggal kejadian, deskripsi
                        lengkap, bukti pendukung, dan kode keamanan.
                    </div>
                </details>

                <details
                    class="group rounded-2xl bg-white/80 dark:bg-gray-900/60 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none text-gray-900 dark:text-gray-100 hover:bg-white/70 rounded-2xl dark:hover:bg-white/5">
                        <span class="font-semibold">Apa saja bentuk file pendukung dalam formulir pengaduan?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="p-4 border-t border-black/5 dark:border-white/10 text-sm text-gray-600 dark:text-gray-300">
                        Maksimal 5 MB per file:<br>
                        - <strong>Foto:</strong> PNG, JPG<br>
                        - <strong>Dokumen:</strong> PDF (misalnya hasil lab)<br>
                        - <strong>Video:</strong> Visual/audio kejadian<br>
                        - <strong>Rekaman suara:</strong> Bukti audio dari saksi/korban
                    </div>
                </details>

                <details
                    class="group rounded-2xl bg-white/80 dark:bg-gray-900/60 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none text-gray-900 dark:text-gray-100 hover:bg-white/70 rounded-2xl dark:hover:bg-white/5">
                        <span class="font-semibold">Apa yang didapat pelapor setelah mengirimkan pengaduan?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="p-4 border-t border-black/5 dark:border-white/10 text-sm text-gray-600 dark:text-gray-300">
                        Pelapor akan mendapat notifikasi bahwa laporan berhasil dikirim.
                        Laporan akan ditindaklanjuti oleh Satgas PPKS sesuai prosedur.
                        Pelapor bisa memantau progres laporan melalui sistem notifikasi.
                    </div>
                </details>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-14 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-fuchsia-600 to-purple-600 p-8 md:p-12 text-white shadow-xl">
                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/15 blur-2xl"
                    aria-hidden="true"></div>
                <div class="max-w-2xl">
                    <h2 class="text-2xl md:text-3xl font-extrabold">Kontak kami</h2>
                    <p class="mt-2 text-white/90">Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu
                        untuk
                        menghubungi kami.</p></br>
                    <p class="text-sm text-gray-200"><i class="fas fa-building mr-2 text-white"></i>Jl. Raya ITS -
                        Kampus
                        PENS,
                        Sukolilo,
                        Surabaya</p>
                    <p class="text-sm text-gray-200"><a href="ppk@div.pens.ac.id"
                            class="text-blue-600 hover:underline"><i
                                class="fas fa-envelope mr-2 text-white"></i>ppk@div.pens.ac.id</a></p>
                    <p class="text-sm text-gray-200"><i class="fas fa-phone mr-2 text-white"></i>031 - 5947280</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-black/5 dark:border-white/10">
        <div
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">© {{ date('Y') }} SafeShield — PENS. Semua hak
                dilindungi.</p>
            <nav class="flex items-center gap-4 text-sm">
                <a href="#features" class="hover:underline">Fitur</a>
                <a href="#hero" class="hover:underline">Beranda</a>
                @auth
                    <a href="{{ $dashboardUrl }}" class="hover:underline">Dashboard</a>
                @endauth
            </nav>
        </div>
    </footer>
</body>

</html>
