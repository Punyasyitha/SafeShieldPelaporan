{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />

    <title>SafeShield — PENS</title>
    <meta name="description"
        content="Sistem pelaporan kekerasan  yang aman, rahasia, dan mudah digunakan di lingkungan kampus." />

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Font (Figtree) jika dipakai di Tailwind config --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;800&display=swap" rel="stylesheet" />

    {{-- Font Awesome (ikon tambahan) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-b from-fuchsia-50 via-white to-white text-purple-900 antialiased">
    {{-- Dekorasi background (glow lembut) --}}
    <div aria-hidden="true" class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-36 -left-28 h-[28rem] w-[36rem] rounded-full bg-fuchsia-300/55 blur-3xl"></div>
        <div class="absolute top-28 right-24 h-44 w-44 rounded-full bg-fuchsia-300/40 blur-2xl"></div>
        <div class="absolute -bottom-40 left-1/3 h-[32rem] w-[42rem] rounded-full bg-purple-300/40 blur-3xl"></div>
    </div>

    {{-- NAVBAR --}}
    <header
        class="sticky top-0 z-20 backdrop-blur supports-[backdrop-filter]:bg-white/70 bg-white/60 border-b border-white/40">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a class="flex items-center gap-2 font-bold text-lg tracking-tight">
                <span class="whitespace-nowrap">
                    <span>SAFE</span><span class="text-fuchsia-600">SHIELD</span>
                </span>
                <img src="{{ asset('assets/images/logoPENS.png') }}" alt="logoPENS"
                    class="w-8 h-8 object-contain ml-3" />
            </a>
        </nav>
    </header>

    {{-- HERO --}}
    <section id="hero" class="relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 md:pt-16 pb-16 md:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                {{-- Kiri: judul + deskripsi + CTA + fitur --}}
                <div class="lg:col-span-7">
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight tracking-tight text-purple-900">
                        Laporkan Tindakan<br />
                        Kekerasan <br />
                        di
                        <span
                            class="align-baseline inline-block rounded-xl px-2.5 py-0.5 bg-fuchsia-300/60 ring-1 ring-white/60 shadow-sm">
                            Kampus
                        </span><br />
                        Bersama SAFESHIELD
                    </h1>

                    <p class="mt-6 text-lg/8 text-slate-600 max-w-2xl">
                        SafeShield akan memberikan pelayanan dalam bentuk form pelaporan dan wawasan
                        tentang Satgas PPKPT. Satgas PPKPT akan menindaklanjuti laporan sesuai
                        Permendikbudristek No. 55/2024.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                @php
                                    $role = auth()->user()->role ?? null;
                                    $dashboardUrl =
                                        $role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                                @endphp
                                <a href="{{ $dashboardUrl }}"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-600 to-purple-600 px-6 py-3 text-white font-semibold shadow-lg ring-1 ring-white/20 hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M3 12h13" />
                                        <path d="m10 7 5 5-5 5" />
                                    </svg>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-600 to-purple-600 px-6 py-3 text-white font-semibold shadow-lg ring-1 ring-white/20 hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v4" />
                                        <path d="M10 14 21 3" />
                                        <path d="M21 10v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h10" />
                                    </svg>
                                    Login SAFESHIELD
                                </a>
                            @endauth
                        @endif

                        <a href="#features"
                            class="inline-flex items-center gap-2 rounded-2xl px-6 py-3 font-semibold text-purple-900 ring-1 ring-purple-900/15 bg-white/60 backdrop-blur hover:bg-white transition">
                            Pelajari Sistem
                        </a>
                    </div>

                    {{-- Kartu 3 kolom --}}
                    <div class="mt-8 grid grid-cols-3 max-w-md gap-4 text-center">
                        <div class="rounded-2xl bg-white/70 p-4 shadow-sm border border-purple-900/10">
                            <div class="text-2xl font-bold text-purple-900">Aman</div>
                            <div class="text-xs text-slate-500 mt-1">Identitas terlindungi</div>
                        </div>
                        <div class="rounded-2xl bg-white/70 p-4 shadow-sm border border-purple-900/10">
                            <div class="text-2xl font-bold text-purple-900">Sigap</div>
                            <div class="text-xs text-slate-500 mt-1">Tindak lanjut cepat</div>
                        </div>
                        <div class="rounded-2xl bg-white/70 p-4 shadow-sm border border-purple-900/10">
                            <div class="text-2xl font-bold text-purple-900">Terbuka</div>
                            <div class="text-xs text-slate-500 mt-1">Progres terpantau</div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: ikon lingkaran dengan ring & animasi --}}
                <div class="lg:col-span-5">
                    <div class="relative">
                        <!-- glow besar di belakang -->
                        <div class="absolute -inset-10 -z-10 rounded-full bg-purple-400/25 blur-3xl"></div>

                        <!-- lingkaran utama: pelan "mengapung" -->
                        <div
                            class="mx-auto grid place-items-center w-72 h-72 md:w-80 md:h-80 rounded-full
                                bg-gradient-to-br from-fuchsia-500 to-purple-600
                                ring-8 ring-purple-300/30 shadow-[0_30px_80px_rgba(147,51,234,0.35)]
                                animate-float motion-reduce:animate-none transform-gpu will-change-transform">

                            <!-- ripple 1 -->
                            <span
                                class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                                h-56 w-56 rounded-full ring-8 ring-white/15
                                animate-ripple motion-reduce:animate-none"></span>
                            <!-- ripple 2 (delay 1.2s) -->
                            <span
                                class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                                h-72 w-72 rounded-full ring-8 ring-white/10
                                animate-[ripple_3.2s_ease-out_1.2s_infinite]
                                motion-reduce:animate-none"></span>

                            <!-- ring berputar sangat pelan (halus) -->
                            <svg class="absolute h-[115%] w-[115%] text-white/20
                                animate-[slowspin_20s_linear_infinite] motion-reduce:animate-none"
                                viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2" />
                            </svg>

                            <!-- inti + ikon -->
                            <div
                                class="grid place-items-center h-28 w-28 rounded-full bg-white/10 ring-8 ring-white/25 backdrop-blur">
                                <svg class="h-14 w-14 text-white/95 animate-pulse motion-reduce:animate-none"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    aria-hidden="true">
                                    <path d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z" />
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
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
                <p class="mt-3 text-slate-600">Didesain untuk keamanan, kecepatan, dan transparansi proses pelaporan.
                </p>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ url('/regulasi') }}" aria-label="Regulasi Resmi PPKPT"
                    class="group block rounded-3xl bg-white/80 p-6 border border-purple-900/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 flex items-center justify-center group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600">
                        <i class="fa-solid fa-scale-balanced text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Regulasi Resmi PPKPT</h3>
                    <p class="mt-1 text-sm text-slate-600">Salinan Permendikbudristek No. 55 Tahun 2024.</p>
                </a>

                <a href="{{ url('/edukasi-kekerasan') }}" aria-label="Buka halaman Edukasi Kekerasan"
                    class="group block rounded-3xl bg-white/80 p-6 border border-purple-900/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 flex items-center justify-center group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600">
                        <i class="fa-solid fa-person-burst text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Bentuk Kekerasan</h3>
                    <p class="mt-1 text-sm text-slate-600">Edukasi bentuk kekerasan khususnya kekerasan .</p>
                </a>

                <a href="{{ url('/tata-cara-pengaduan') }}" aria-label="Buka halaman Tata Cara"
                    class="group block rounded-3xl bg-white/80 p-6 border border-purple-900/10 shadow transition transform-gpu hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500/50">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 flex items-center justify-center group-hover:bg-fuchsia-600/15 group-hover:text-fuchsia-600">
                        <i class="fa-solid fa-stairs text-[22px] leading-none"></i>
                    </div>
                    <h3 class="mt-4 font-semibold">Tata Cara Pengaduan</h3>
                    <p class="mt-1 text-sm text-slate-600">Langkah-langkah pengaduan melalui website SafeShield.</p>
                </a>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-14 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl md:text-6xl font-extrabold tracking-tight">FAQs</h2>
                <p class="mt-3 text-slate-600">Daftar pertanyaan seputar SafeShield.</p>
            </div>

            <div class="mt-10 max-w-3xl mx-auto space-y-4">
                <details class="group rounded-2xl bg-white/80 border border-purple-900/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none hover:bg-white/90 rounded-2xl">
                        <span class="font-semibold">Apa saja fitur yang ada pada website ini?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div class="p-4 border-t border-purple-900/10 text-sm text-slate-600">
                        Website ini memiliki empat fitur utama diantaranya:<br>
                        <strong>1. Beranda:</strong> Artikel terbaru dari Satgas PPKS PENS.<br>
                        <strong>2. Materi:</strong> Modul pembelajaran<br>
                        <strong>3. Pengaduan:</strong> Formulir pelaporan kasus kekerasan/pelecehan.<br>
                        <strong>4. Progress Pengaduan:</strong> Notifikasi status pelaporan.
                    </div>
                </details>

                <details class="group rounded-2xl bg-white/80 border border-purple-900/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none hover:bg-white/90 rounded-2xl">
                        <span class="font-semibold">Bagaimana pengguna bisa mendapatkan edukasi modul PPKS?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div class="p-4 border-t border-purple-900/10 text-sm text-slate-600">
                        Pengguna wajib login terlebih dahulu. Setelah login, pilih menu Materi pada sidebar. Terdapat
                        empat modul pembelajaran yang harus diselesaikan berurutan untuk memberikan pemahaman PPKS dan
                        menumbuhkan sikap anti kekerasan.
                    </div>
                </details>

                <details class="group rounded-2xl bg-white/80 border border-purple-900/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none hover:bg-white/90 rounded-2xl">
                        <span class="font-semibold">Bagaimana cara melaporkan tindakan kekerasan atau pelecehan di
                            PENS?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div class="p-4 border-t border-purple-900/10 text-sm text-slate-600">
                        Login terlebih dahulu, lalu buka menu Pengaduan. Isi formulir dengan:<br>
                        <strong>1. Identitas:</strong> Nama lengkap, nomor telepon, email.<br>
                        <strong>2. Detail Pengaduan:</strong> Nama terlapor, tempat & tanggal kejadian, deskripsi
                        lengkap, bukti pendukung, dan kode keamanan.
                    </div>
                </details>

                <details class="group rounded-2xl bg-white/80 border border-purple-900/10 shadow">
                    <summary
                        class="flex items-center justify-between w-full px-5 py-4 cursor-pointer select-none hover:bg-white/90 rounded-2xl">
                        <span class="font-semibold">Apa saja bentuk file pendukung dalam formulir pengaduan?</span>
                        <i
                            class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div class="p-4 border-t border-purple-900/10 text-sm text-slate-600">
                        Maksimal 5 MB per file:<br>
                        - <strong>Foto:</strong> PNG, JPG<br>
                        - <strong>Dokumen:</strong> PDF (misalnya hasil lab)<br>
                        - <strong>Video:</strong> Visual/audio kejadian<br>
                        - <strong>Rekaman suara:</strong> Bukti audio dari saksi/korban
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
                        untuk menghubungi kami.</p>
                    <br />
                    <p class="text-sm text-white/80"><i class="fas fa-building mr-2 text-white"></i>Jl. Raya ITS -
                        Kampus PENS, Sukolilo, Surabaya</p>
                    <p class="text-sm text-white/80">
                        <a href="mailto:ppk@div.pens.ac.id"
                            class="underline decoration-white/60 underline-offset-4 hover:decoration-white">
                            <i class="fas fa-envelope mr-2 text-white"></i>ppk@div.pens.ac.id
                        </a>
                    </p>
                    <p class="text-sm text-white/80"><i class="fas fa-phone mr-2 text-white"></i>031 - 5947280</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-purple-900/10">
        <div
            class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-600">© {{ date('Y') }} SafeShield — PENS. Semua hak dilindungi.</p>
            <nav class="flex items-center gap-4 text-sm">
                <a href="#features" class="hover:underline">Fitur</a>
                <a href="#hero" class="hover:underline">Beranda</a>
                @auth
                    @php
                        $role = auth()->user()->role ?? null;
                        $dashboardUrl = $role === 'admin' ? route('admin.dashboard') : route('user.dashboard');
                    @endphp
                    <a href="{{ $dashboardUrl }}" class="hover:underline">Dashboard</a>
                @endauth
            </nav>
        </div>
    </footer>
</body>

</html>
