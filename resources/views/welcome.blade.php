{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white justify-center"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white justify-center"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white justify-center"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main>
                        <h1 class="text-4xl font-bold text-black drop-shadow-lg text-center">
                            Selamat Datang di SafeShield
                        </h1>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SafeShield</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        .highlight-circle {
            position: relative;
            display: inline-block;
            z-index: 0;
            font-weight: bold;
        }

        .highlight-circle::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            border-radius: 50%;
            /* super round */
            padding: 3px;
            /* border thickness */
            background: linear-gradient(90deg, #d946ef, #6366f1);
            /* pink to blue */
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            box-sizing: border-box;
            transform: rotate(183deg); /* Sudut kemiringan */
            transform-origin: center center;
        }
    </style>

</head>

{{-- <div class="h-screen flex-1 flex flex-col justify-center items-center text-center px-4 py-20 relative">
        <!-- Elemen dekorasi kiri bawah diganti gambar -->
        <img src="{{ asset('/assets/images/Vector.png') }}" alt="Dekorasi"
            class="absolute bottom-0 left-0 object-contain -z-10 select-none pointer-events-none">

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight max-w-4xl">
            Ciptakan Kesadaran Diri <br>
            tentang Pentingnya <br>
            Sikap <span class="highlight-circle">Anti Pelecehan</span> <br>
            dan Kekerasan Seksual
        </h1>

        <!-- Tombol login -->
        <div class="mt-10">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-gradient-to-r from-fuchsia-600 to-purple-500 text-white px-8 py-3 rounded-full font-semibold shadow-md hover:scale-105 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-gradient-to-r from-fuchsia-600 to-purple-500 text-white px-8 py-3 rounded-full font-semibold shadow-md hover:scale-105 transition">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <p class="mt-3 text-sm text-gray-600">Apabila belum memiliki akun, silahkan
                            <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Register
                            </a>
                        </p>
                    @endif
                @endauth
            @endif
        </div>
    </div> --}}

<body class="font-sans antialiased bg-gradient-to-br from-[#f8f4ff] to-white min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="backdrop-blur-md bg-white/30 sticky top-0 z-50 px-8 py-4 flex justify-between items-center shadow-md">
        <div class="text-gray-800 text-xl font-bold tracking-wider">
            SAFE<span class="text-purple-500 font-bold">SHIELD</span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex gap-6 text-gray-800 font-medium">
            <a href="#hero" class="hover:text-purple-600">Home</a>
            <a href="#about" class="hover:text-purple-600">About</a>
            <a href="#information" class="hover:text-purple-600">Information</a>
            <a href="#faq" class="hover:text-purple-600">FAQ</a>
            <a href="#contact" class="hover:text-purple-600">Contact</a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden text-gray-800 relative">
            <button id="menu-toggle" aria-label="Toggle menu">
                <!-- Burger Icon (SVG) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Mobile Dropdown Menu -->
            <div id="mobile-menu"
                class="fixed top-16 left-0 right-0 w-full bg-white/75 backdrop-blur-md shadow-md p-6 hidden flex-col space-y-4 text-gray-800 font-medium z-40">
                <a href="#hero" class="hover:text-purple-600">Home</a><br>
                <a href="#about" class="hover:text-purple-600">About</a><br>
                <a href="#information" class="hover:text-purple-600">Information</a><br>
                <a href="#faq" class="hover:text-purple-600">FAQ</a><br>
                <a href="#contact" class="hover:text-purple-600">Contact</a><br>
            </div>
        </div>
    </nav>

    <!-- Mobile menu (initially hidden) -->
    <div id="mobile-menu"
        class="md:hidden hidden flex-col bg-white px-8 py-4 shadow-md text-gray-800 font-medium space-y-3">
        <a href="#hero" class="hover:underline hover:text-purple-600">Home</a>
        <a href="#about" class="hover:underline hover:text-purple-600">About</a>
        <a href="#information" class="hover:underline hover:text-purple-600">Information</a>
        <a href="#faq" class="hover:underline hover:text-purple-600">FAQ</a>
        <a href="#contact" class="hover:underline hover:text-purple-600">Contact</a>
    </div>

    <!-- Hero Section -->
    <section id="hero"
        class="min-h-screen flex flex-col justify-center items-center text-center px-4 pt-16 pb-[180px] relative overflow-hidden bg-gradient-to-b from-purple-100 via-white to-fuchsia-100">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight max-w-4xl">
            Ciptakan Kesadaran Diri <br>
            tentang Pentingnya <br>
            Sikap <span class="highlight-circle">Anti Pelecehan</span> <br>
            dan Kekerasan Seksual
        </h1>

        <div class="mt-10">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="bg-gradient-to-r from-fuchsia-600 to-purple-500 text-white px-8 py-3 rounded-full font-semibold shadow-md hover:scale-105 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-gradient-to-r from-fuchsia-600 to-purple-500 text-white px-8 py-3 rounded-full font-semibold shadow-md hover:scale-105 transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <p class="mt-3 text-sm text-gray-600">Apabila belum memiliki akun, silahkan
                            <a href="{{ route('register') }}"
                                class="text-blue-600 font-semibold hover:underline">Register</a>
                        </p>
                    @endif
                @endauth
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section id="about"
        class="relative z-10 w-full min-h-[350px] pt-16 pb-24 px-6 md:px-32 bg-white overflow-hidden">

        <!-- Dekorasi atas about (lanjutan dari bawah hero) -->
        <img src="{{ asset('/assets/images/VectorFull.png') }}" alt="Dekorasi Atas"
            class="absolute top-[-180px] left-0 -translate-x-10 sm:-translate-x-16 md:-translate-x-24 scale-[0.9] object-contain -z-10 select-none pointer-events-none" />

        <!-- Dekorasi kanan bawah -->
        <img src="{{ asset('/assets/images/Vector 2.png') }}" alt="Dekorasi Kanan"
            class="absolute bottom-0 right-0 w-60 md:w-72 lg:w-80 -z-10" />

        <div class="grid grid-cols-1 md:grid-cols-2 mt-16 max-w-6xl mx-auto gap-12">
            <h2 class="text-5xl font-extrabold text-gray-900 text-center md:text-left">
                SAFESHIELD
            </h2>
            <p class="text-base text-gray-800 leading-relaxed text-center md:text-center">
                Website ini memberikan pelayanan berupa form pelaporan tindakan kekerasan dan pelecehan seksual,
                serta wawasan <strong>tentang PPKS</strong>.
            </p>
        </div>
    </section>

    <!-- Information Section -->
    <section id="information"
        class="relative py-20 px-6 md:px-20 overflow-hidden bg-gradient-to-b from-purple-100 via-white to-fuchsia-100">
        <div class="max-w-5xl mx-auto text-center relative z-10">
            <h2 class="text-5xl font-extrabold text-gray-800 mb-6">Tata Cara Pengaduan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-black mb-2">Cek Kelengkapan Laporan Pengaduan</h3>
                    <p class="text-gray-900 text-sm">Pengaduan dengan data lengkap dan sesuai dengan kriteria pengaduan
                        akan mempercepat proses tindak lanjut atas aduan Anda.</p>
                </div>
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-black mb-2">Isi Formulir Pengaduan</h3>
                    <p class="text-gray-900 text-sm">Klik menu "Pengaduan" yang terdapat pada bagian menu. Isi dan
                        lengkapi formulir pengaduan yang telah disediakan.</p>
                </div>
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-black mb-2">Kirim Formulir Pengaduan Anda</h3>
                    <p class="text-gray-900 text-sm">Apabila pengaduan berhasil dikirm, Anda akan memperoleh notifikasi
                        “berhasil” terkirim dan akan diproses.</p>
                </div>
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-black mb-2">Pantau Pengaduan</h3>
                    <p class="text-gray-900 text-sm">Melalui halaman status pelaporan Anda dapat memantau pengaduan
                        yang
                        sudah Anda kirim berdasarkan notifikasi yang diterima.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="relative py-20 bg-white px-6 md:px-20 overflow-hidden">

        <!-- Dekorasi atas -->
        <img src="{{ asset('/assets/images/Vector 4.png') }}" alt="Dekorasi Kiri"
            class="absolute bottom-0 left-0 w-[600px] max-w-none opacity-60 -z-0 select-none pointer-events-none" />

        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl font-extrabold text-gray-800 mb-10">FAQs</h2>
            <div class="space-y-4 text-left" id="faq-container">

                <!-- FAQ Item -->
                <div class="border rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center px-4 py-3 bg-white text-left text-gray-800 font-semibold faq-toggle">
                        Apa saja fitur yang ada pada website ini?
                        <span class="text-xl">+</span>
                    </button>
                    <div class="hidden px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                        Website ini memiliki empat fitur utama diantaranya:<br>
                        <strong>1. Beranda:</strong> Artikel terbaru dari Satgas PPKS PENS.<br>
                        <strong>2. Materi:</strong> Modul pembelajaran:<br>
                        - Filosofi Pendidikan di Indonesia<br>
                        - Mengenal Kekerasan<br>
                        - Memahami Kekerasan Seksual<br>
                        - Memahami Dampak Kekerasan Seksual<br>
                        <strong>3. Pengaduan:</strong> Formulir pelaporan kasus kekerasan/pelecehan seksual.<br>
                        <strong>4. Progress Pengaduan:</strong> Notifikasi status pelaporan.
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="border rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center px-4 py-3 bg-white text-left text-gray-800 font-semibold faq-toggle">
                        Bagaimana pengguna bisa mendapatkan edukasi modul PPKS?
                        <span class="text-xl">+</span>
                    </button>
                    <div class="hidden px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                        Pengguna wajib login terlebih dahulu. Setelah login, pilih menu Materi pada sidebar. Terdapat
                        empat modul pembelajaran yang harus diselesaikan berurutan untuk memberikan pemahaman PPKS dan
                        menumbuhkan sikap anti kekerasan seksual.
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="border rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center px-4 py-3 bg-white text-left text-gray-800 font-semibold faq-toggle">
                        Bagaimana cara melaporkan tindakan kekerasan atau pelecehan seksual di PENS?
                        <span class="text-xl">+</span>
                    </button>
                    <div class="hidden px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                        Login terlebih dahulu, lalu buka menu Pengaduan. Isi formulir dengan:<br>
                        <strong>1. Identitas:</strong> Nama lengkap, nomor telepon, email.<br>
                        <strong>2. Detail Pengaduan:</strong> Nama terlapor, tempat & tanggal kejadian, deskripsi
                        lengkap, bukti pendukung, dan kode keamanan.
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="border rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center px-4 py-3 bg-white text-left text-gray-800 font-semibold faq-toggle">
                        Apa saja bentuk file pendukung dalam formulir pengaduan?
                        <span class="text-xl">+</span>
                    </button>
                    <div class="hidden px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                        Maksimal 5 MB per file:<br><br>
                        - <strong>Foto:</strong> PNG, JPG<br>
                        - <strong>Dokumen:</strong> PDF (misalnya hasil lab)<br>
                        - <strong>Video:</strong> Visual/audio kejadian<br>
                        - <strong>Rekaman suara:</strong> Bukti audio dari saksi/korban
                    </div>
                </div>

                <!-- FAQ Item -->
                <div class="border rounded-lg overflow-hidden">
                    <button
                        class="w-full flex justify-between items-center px-4 py-3 bg-white text-left text-gray-800 font-semibold faq-toggle">
                        Apa yang didapat pelapor setelah mengirimkan pengaduan?
                        <span class="text-xl">+</span>
                    </button>
                    <div class="hidden px-4 pb-4 text-sm text-gray-600 leading-relaxed">
                        Pelapor akan mendapat notifikasi bahwa laporan berhasil dikirim.
                        Laporan akan ditindaklanjuti oleh Satgas PPKS sesuai prosedur.
                        Pelapor bisa memantau progres laporan melalui sistem notifikasi.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact"
        class="py-20 bg-gray-100 px-6 md:px-20  bg-gradient-to-b from-purple-100 via-white to-fuchsia-100">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-5xl font-extrabold text-gray-800 mb-4">Hubungi Kami</h2>
            <p class="text-gray-700 mb-6">Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk
                menghubungi kami.</p>
            <p class="text-sm text-gray-600"><i class="fas fa-building mr-2 text-black"></i>Jl. Raya ITS - Kampus
                PENS,
                Sukolilo,
                Surabaya</p>
            <p class="text-sm text-gray-600"><a href="mailto:safeshield25@gmail.com"
                    class="text-blue-600 hover:underline"><i
                        class="fas fa-envelope mr-2 text-black"></i>safeshield25@gmail.com</a></p>
            <p class="text-sm text-gray-600"><i class="fas fa-phone mr-2 text-black"></i>0812-1675-6463</p>
        </div>
    </section>

    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('span');

                const isOpen = !content.classList.contains('hidden');

                // Tutup semua FAQ
                document.querySelectorAll('#faq-container .faq-toggle').forEach(btn => {
                    btn.nextElementSibling.classList.add('hidden');
                    btn.querySelector('span').textContent = '+';
                });

                // Toggle yang diklik
                if (!isOpen) {
                    content.classList.remove('hidden');
                    icon.textContent = '−';
                }
            });
        });

        const toggleBtn = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Optional: Close on click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        });
    </script>
</body>

</html>
