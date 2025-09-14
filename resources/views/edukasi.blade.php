{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">

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
                        Edukasi: Kekerasan Seksual & Kebijakannya
                    </h1>
                    <p class="mt-4 text-lg/8 text-gray-600 dark:text-gray-300">
                        Halaman ini memberikan pemahaman dasar tentang bentuk-bentuk kekerasan terutama kekerasan
                        seksual dan kebijakan yang mengandung kekerasan.
                    </p>
                </div>
            </div>
        </section>

        <!-- GRID SECTIONS -->
        {{-- <section class="py-6 md:py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Definisi -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-circle-info text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Apa itu Kekerasan Seksual?</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Setiap perbuatan merendahkan, menghina, melecehkan, dan/atau menyerang tubuh, dan/atau fungsi
                        reproduksi seseorang, karena ketimpangan relasi kuasa dan/atau gender, yang berakibat atau dapat
                        berakibat pada penderitaan psikis dan/atau fisik termasuk yang mengganggu fungsi reproduksi
                        seseorang dan hilang kesempatan melaksanakan pendidikan dan/atau pekerjaan dengan aman dan
                        optimal.
                    </p>
                </article>

                <!-- Bentuk-bentuk -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-person-burst text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Bentuk Kekerasan Seksual</h2>
                    <ul class="mt-1 space-y-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside">
                        <li>Penyampaian ujaran yang mendiskriminasi atau melecehkan tampilan fisik, kondisi tubuh,
                            dan/atau identitas gender Korban;</li>
                        <li>perbuatan memperlihatkan alat kelamin dengan sengaja tanpa persetujuan Korban;</li>
                        <li>penyampaian ucapan yang memuat rayuan, lelucon, dan/atau siulan yang bernuansa seksual;</li>
                        <li>perbuatan menatap Korban dengan nuansa seksual dan/atau membuat Korban merasa tidak nyaman;
                        </li>
                        <li>pengiriman pesan, lelucon, gambar, foto, audio, dan/atau video bernuansa seksual kepada
                            Korban meskipun sudah dilarang Korban;</li>
                    </ul>
                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">Catatan: contoh bersifat umum dan
                        non‑grafis,
                        untuk edukasi.</p>
                </article>

                <!-- Prinsip Kebijakan -->
                <article
                    class="rounded-3xl bg-white/80 dark:bg-gray-900/60 p-6 ring-1 ring-black/5 dark:ring-white/10 shadow">
                    <div
                        class="h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <i class="fa-solid fa-shield-heart text-[22px]"></i>
                    </div>
                    <h2 class="mt-4 font-semibold">Prinsip Kebijakan Kampus</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        Kebijakan yang mengandung kekerasan. Kebijakan yang mengandung kekerasan merupakan kebijakan
                        tertulis maupun tidak tertulis yang berpotensi atau menimbulkan terjadinya kekerasan. Kebijakan
                        tertulis yang dimaksud meliputi:
                    </p>
                    <ul class="mt-1 space-y-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside">
                        <li><span class="font-medium">Surat keputusan</span></li>
                        <li><span class="font-medium">Surat ederan</span></li>
                        <li><span class="font-medium">Nota dinas</span></li>
                        <li><span class="font-medium">Pedoman</span></li>
                        <li><span class="font-medium">Bentuk kebijakan tertulis lainnya</span></li>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                            Sementara itu, kebijakan tidak tertulis mencakup:
                        </p>
                        <li><span class="font-medium">Imbauan</span></li>
                        <li><span class="font-medium">Intruksi dan/atau</span></li>
                        <li><span class="font-medium">Bentuk tindakan lainnya</span></li>
                    </ul>
                </article>
            </div>
        </section> --}}
        <section class="py-6 md:py-5">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">
                <!-- Definisi (Dropdown) -->
                <details class="group w-full">
                    <summary
                        class="flex items-center justify-between w-full rounded-lg border border-purple-400 bg-white px-5 py-3 text-gray-900 shadow-sm cursor-pointer select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 hover:bg-white/90 dark:bg-gray-900 dark:text-gray-100 dark:border-purple-500/60 dark:hover:bg-gray-900/80">
                        <span class="font-semibold">Apa itu Kekerasan Seksual?</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="mt-3 rounded-xl border border-black/5 dark:border-white/10 bg-white/60 dark:bg-gray-900/40 p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Setiap perbuatan merendahkan, menghina, melecehkan, dan/atau menyerang tubuh, dan/atau
                            fungsi
                            reproduksi seseorang, karena ketimpangan relasi kuasa dan/atau gender, yang berakibat atau
                            dapat
                            berakibat pada penderitaan psikis dan/atau fisik termasuk yang mengganggu fungsi reproduksi
                            seseorang dan hilang kesempatan melaksanakan pendidikan dan/atau pekerjaan dengan aman dan
                            optimal.
                        </p>
                    </div>
                </details>

                <!-- Bentuk Kekerasan (Dropdown) -->
                <details class="group w-full">
                    <summary
                        class="flex items-center justify-between w-full rounded-lg border border-purple-400 bg-white px-5 py-3 text-gray-900 shadow-sm cursor-pointer select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 hover:bg-white/90 dark:bg-gray-900 dark:text-gray-100 dark:border-purple-500/60 dark:hover:bg-gray-900/80">
                        <span class="font-semibold">Bentuk Kekerasan Seksual</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="mt-3 rounded-xl border border-black/5 dark:border-white/10 bg-white/60 dark:bg-gray-900/40 p-4">
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside">
                            <li>penyampaian ujaran yang mendiskriminasi atau melecehkan tampilan fisik, kondisi tubuh,
                                dan/atau identitas gender Korban</li>
                            <li>perbuatan memperlihatkan alat kelamin dengan sengaja tanpa persetujuan Korban</li>
                            <li>penyampaian ucapan yang memuat rayuan, lelucon, dan/atau siulan yang bernuansa seksual
                            </li>
                            <li>perbuatan menatap Korban dengan nuansa seksual dan/atau membuat Korban merasa tidak
                                nyaman</li>
                            <li>pengiriman pesan, lelucon, gambar, foto, audio, dan/atau video bernuansa seksual kepada
                                Korban meskipun sudah dilarang Korban</li>
                            <li>perbuatan mengambil, merekam, dan/atau mengedarkan foto dan/atau rekaman audio dan/atau
                                visual Korban yang bernuansa seksual tanpa persetujuan Korban</li>
                            <li>perbuatan mengunggah foto tubuh dan/atau informasi pribadi Korban yang bernuansa seksual
                                tanpa persetujuan Korban</li>
                            <li>penyebaran informasi terkait tubuh dan/atau informasi pribadi Korban yang bernuansa
                                seksual tanpa persetujuan Korban</li>
                            <li>perbuatan mengintip atau dengan sengaja melihat Korban yang sedang melakukan kegiatan
                                secara pribadi dan/atau pada ruang yang bersifat pribadi</li>
                            <li>perbuatan membujuk, menjanjikan, atau menawarkan sesuatu kepada Korban untuk melakukan
                                transaksi atau kegiatan seksual yang tidak disetujui Korban</li>
                            <li>pemberian hukuman atau sanksi yang bernuansa seksual</li>
                            <li>perbuatan menyentuh, mengusap, meraba, memegang, memeluk, mencium, dan/atau menggosokkan
                                bagian tubuhnya pada tubuh Korban tanpa persetujuan Korban</li>
                            <li>perbuatan membuka pakaian Korban tanpa persetujuan Korban</li>
                            <li>pemaksaan terhadap Korban untuk melakukan transaksi atau kegiatan seksual</li>
                            <li>praktik budaya komunitas Warga Kampus yang bernuansa Kekerasan seksual</li>
                            <li>percobaan perkosaan walaupun penetrasi tidak terjadi</li>
                            <li>perkosaan termasuk penetrasi dengan benda atau bagian tubuh selain alat kelamin</li>
                            <li>pemaksaan atau perbuatan memperdayai Korban untuk melakukan aborsi</li>
                            <li>pemaksaan atau perbuatan memperdayai Korban untuk hamil</li>
                            <li>pemaksaan sterilisasi</li>
                            <li>penyiksaan seksual</li>
                            <li>eksploitasi seksual</li>
                            <li>perbudakan seksual</li>
                            <li>tindak pidana perdagangan orang yang ditujukan untuk eksploitasi seksual</li>
                            <li>pembiaran terjadinya Kekerasan seksual dengan sengaja; dan/atau</li>
                            <li>perbuatan lain yang dinyatakan sebagai Kekerasan seksual sesuai dengan ketentuan
                                peraturan perundang-undangan</li>
                        </ul>
                    </div>
                </details>

                <!-- Prinsip Kebijakan -->
                <details class="group w-full">
                    <summary
                        class="flex items-center justify-between w-full rounded-lg border border-purple-400 bg-white px-5 py-3 text-gray-900 shadow-sm cursor-pointer select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 hover:bg-white/90 dark:bg-gray-900 dark:text-gray-100 dark:border-purple-500/60 dark:hover:bg-gray-900/80">
                        <span class="font-semibold">Prinsip Kebijakan Kampus</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
                    </summary>
                    <div
                        class="mt-3 rounded-xl border border-black/5 dark:border-white/10 bg-white/60 dark:bg-gray-900/40 p-4">
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                            Kebijakan yang mengandung kekerasan. Kebijakan yang mengandung kekerasan merupakan kebijakan
                            tertulis maupun tidak tertulis yang berpotensi atau menimbulkan terjadinya kekerasan.
                            Kebijakan
                            tertulis yang dimaksud meliputi:
                        </p>
                        <ul class="mt-1 space-y-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside">
                            <li><span class="font-medium">Surat keputusan</span></li>
                            <li><span class="font-medium">Surat ederan</span></li>
                            <li><span class="font-medium">Nota dinas</span></li>
                            <li><span class="font-medium">Pedoman</span></li>
                            <li><span class="font-medium">Bentuk kebijakan tertulis lainnya</span></li>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                Sementara itu, kebijakan tidak tertulis mencakup:
                            </p>
                            <li><span class="font-medium">Imbauan</span></li>
                            <li><span class="font-medium">Intruksi dan/atau</span></li>
                            <li><span class="font-medium">Bentuk tindakan lainnya</span></li>
                        </ul>
                    </div>
                </details>

            </div>
        </section>
    </main>
</body>

</html>
