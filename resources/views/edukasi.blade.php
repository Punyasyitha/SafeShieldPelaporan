{{-- resources/views/welcome.blade.php (Edukasi) --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="color-scheme" content="light" />

  <title>SafeShield — PENS</title>
  <meta name="description"
        content="Sistem pelaporan kekerasan seksual yang aman, rahasia, dan mudah digunakan di lingkungan kampus." />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-b from-fuchsia-50 via-white to-white text-purple-900 antialiased">
  {{-- Background dekoratif (warna sama seperti landing) --}}
  <div aria-hidden="true" class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-36 -left-28 h-[28rem] w-[36rem] rounded-full bg-fuchsia-300/55 blur-3xl"></div>
    <div class="absolute top-28 right-24 h-44 w-44 rounded-full bg-fuchsia-300/40 blur-2xl"></div>
    <div class="absolute -bottom-40 left-1/3 h-[32rem] w-[42rem] rounded-full bg-purple-300/40 blur-3xl"></div>
  </div>

  {{-- NAVBAR --}}
  <header class="sticky top-0 z-20 backdrop-blur supports-[backdrop-filter]:bg-white/70 bg-white/60 border-b border-white/40">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <a class="flex items-center gap-2 font-bold text-lg tracking-tight">
        <span class="flex items-baseline gap-0 whitespace-nowrap">
          <span class="sm:inline">SAFE</span><span class="text-fuchsia-600 font-bold">SHIELD</span>
        </span>
        <img src="{{ asset('assets/images/logoPENS.png') }}" alt="logoPENS" class="w-8 h-8 object-contain ml-3" />
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
          <p class="mt-4 text-lg/8 text-slate-600">
            Halaman ini memberikan pemahaman dasar tentang bentuk-bentuk kekerasan terutama
            kekerasan seksual dan kebijakan yang mengandung kekerasan.
          </p>
        </div>
      </div>
    </section>

    <!-- SECTION DROPDOWN (glassy, light) -->
    <section class="py-6 md:py-5">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-4">

        {{-- Block helper --}}
        @php
          $summaryBase = 'flex items-center justify-between w-full rounded-xl border border-purple-900/10 bg-white/85
                          backdrop-blur px-5 py-3 text-purple-900 shadow-sm cursor-pointer select-none
                          hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-fuchsia-500';
          $panelBase   = 'mt-3 rounded-xl border border-purple-900/10 bg-white/80 backdrop-blur p-4 shadow-sm';
        @endphp

        <!-- Definisi -->
        <details class="group w-full">
          <summary class="{{ $summaryBase }}">
            <span class="font-semibold">Apa itu Kekerasan Seksual?</span>
            <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="{{ $panelBase }}">
            <p class="text-sm text-slate-600">
              Setiap perbuatan merendahkan, menghina, melecehkan, dan/atau menyerang tubuh, dan/atau fungsi
              reproduksi seseorang, karena ketimpangan relasi kuasa dan/atau gender, yang berakibat atau dapat
              berakibat pada penderitaan psikis dan/atau fisik termasuk yang mengganggu fungsi reproduksi
              seseorang dan hilang kesempatan melaksanakan pendidikan dan/atau pekerjaan dengan aman dan optimal.
            </p>
          </div>
        </details>

        <!-- Bentuk Kekerasan -->
        <details class="group w-full">
          <summary class="{{ $summaryBase }}">
            <span class="font-semibold">Bentuk Kekerasan Seksual</span>
            <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="{{ $panelBase }}">
            <ul class="space-y-2 text-sm text-slate-600 list-disc list-inside">
              <li>penyampaian ujaran yang mendiskriminasi atau melecehkan tampilan fisik, kondisi tubuh, dan/atau identitas gender Korban</li>
              <li>perbuatan memperlihatkan alat kelamin dengan sengaja tanpa persetujuan Korban</li>
              <li>penyampaian ucapan yang memuat rayuan, lelucon, dan/atau siulan yang bernuansa seksual</li>
              <li>perbuatan menatap Korban dengan nuansa seksual dan/atau membuat Korban merasa tidak nyaman</li>
              <li>pengiriman pesan, lelucon, gambar, foto, audio, dan/atau video bernuansa seksual kepada Korban meskipun sudah dilarang Korban</li>
              <li>perbuatan mengambil, merekam, dan/atau mengedarkan foto/rekaman Korban bernuansa seksual tanpa persetujuan</li>
              <li>perbuatan mengunggah atau menyebarkan informasi pribadi Korban bernuansa seksual tanpa persetujuan</li>
              <li>mengintip Korban di ruang/aktivitas privat</li>
              <li>membujuk/menjanjikan sesuatu untuk aktivitas seksual yang tidak disetujui Korban</li>
              <li>pemberian hukuman atau sanksi yang bernuansa seksual</li>
              <li>menyentuh/memegang/memeluk/mencium/menggosokkan bagian tubuh pada Korban tanpa persetujuan</li>
              <li>membuka pakaian Korban tanpa persetujuan</li>
              <li>pemaksaan transaksi atau kegiatan seksual</li>
              <li>praktik budaya komunitas Warga Kampus yang bernuansa kekerasan seksual</li>
              <li>percobaan perkosaan & perkosaan (termasuk penetrasi dengan benda/bagian tubuh selain alat kelamin)</li>
              <li>pemaksaan/perdayaan untuk aborsi/hamil/sterilisasi</li>
              <li>penyiksaan, eksploitasi, perbudakan seksual, TPPO untuk eksploitasi seksual</li>
              <li>pembiaran terjadinya kekerasan seksual dengan sengaja; dan/atau</li>
              <li>perbuatan lain yang dinyatakan sebagai kekerasan seksual sesuai peraturan perundang-undangan</li>
            </ul>
          </div>
        </details>

        <!-- Prinsip Kebijakan -->
        <details class="group w-full">
          <summary class="{{ $summaryBase }}">
            <span class="font-semibold">Prinsip Kebijakan Kampus</span>
            <i class="fa-solid fa-chevron-down transition-transform duration-300 group-open:rotate-180"></i>
          </summary>
          <div class="{{ $panelBase }}">
            <p class="text-sm text-slate-600">
              Kebijakan yang mengandung kekerasan dapat berbentuk tertulis maupun tidak tertulis.
              Kebijakan tertulis meliputi:
            </p>
            <ul class="mt-2 space-y-2 text-sm text-slate-600 list-disc list-inside">
              <li><span class="font-medium">Surat keputusan</span></li>
              <li><span class="font-medium">Surat edaran</span></li>
              <li><span class="font-medium">Nota dinas</span></li>
              <li><span class="font-medium">Pedoman</span></li>
              <li><span class="font-medium">Bentuk kebijakan tertulis lainnya</span></li>
            </ul>
            <p class="mt-3 text-sm text-slate-600">Kebijakan tidak tertulis mencakup:</p>
            <ul class="mt-2 space-y-2 text-sm text-slate-600 list-disc list-inside">
              <li><span class="font-medium">Imbauan</span></li>
              <li><span class="font-medium">Instruksi</span></li>
              <li><span class="font-medium">Bentuk tindakan lainnya</span></li>
            </ul>
          </div>
        </details>

      </div>
    </section>
  </main>
</body>
</html>
