{{-- resources/views/welcome.blade.php — Tata Cara Pengaduan (light) --}}
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
  {{-- Background dekoratif (sama seperti landing) --}}
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
            Tata Cara Pengaduan
          </h1>
          <p class="mt-4 text-lg/8 text-slate-600">
            Halaman ini memberikan pemahaman dan petunjuk berisi langkah-langkah melakukan
            pengaduan ke website SafeShield.
          </p>
        </div>
      </div>
    </section>

    <!-- GRID STEPS (glassy cards) -->
    <section class="py-6 md:py-10">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid gap-6 md:grid-cols-2">
        @php
          $card = 'rounded-3xl bg-white/85 backdrop-blur border border-purple-900/10 p-6 shadow-md';
          $icon = 'h-10 w-10 rounded-xl bg-fuchsia-600/10 text-fuchsia-700 flex items-center justify-center';
          $text = 'mt-1 text-sm text-slate-600';
        @endphp

        <!-- Step 1 -->
        <article class="{{ $card }}">
          <div class="{{ $icon }}"><i class="fa-solid fa-user-check text-[22px]"></i></div>
          <h2 class="mt-4 font-semibold">Cek Kelengkapan Laporan Pengaduan</h2>
          <p class="{{ $text }}">
            Pengaduan dengan data lengkap dan sesuai kriteria akan mempercepat proses tindak lanjut atas aduan Anda.
          </p>
        </article>

        <!-- Step 2 -->
        <article class="{{ $card }}">
          <div class="{{ $icon }}"><i class="fa-solid fa-keyboard text-[22px]"></i></div>
          <h2 class="mt-4 font-semibold">Isi Formulir Pengaduan</h2>
          <p class="{{ $text }}">
            Klik menu <span class="font-medium">“Pengaduan”</span> pada navigasi, lalu isi dan lengkapi formulir yang disediakan.
          </p>
        </article>

        <!-- Step 3 -->
        <article class="{{ $card }}">
          <div class="{{ $icon }}"><i class="fa-solid fa-paper-plane text-[22px]"></i></div>
          <h2 class="mt-4 font-semibold">Kirim Formulir Pengaduan Anda</h2>
          <p class="{{ $text }}">
            Setelah formulir dikirim, Anda akan memperoleh notifikasi <span class="font-medium">“berhasil”</span> dan laporan diproses.
          </p>
        </article>

        <!-- Step 4 -->
        <article class="{{ $card }}">
          <div class="{{ $icon }}"><i class="fa-solid fa-rectangle-list text-[22px]"></i></div>
          <h2 class="mt-4 font-semibold">Pantau Pengaduan</h2>
          <p class="{{ $text }}">
            Buka halaman status pelaporan untuk memantau progres pengaduan berdasarkan notifikasi yang diterima.
          </p>
        </article>
      </div>
    </section>
  </main>
</body>
</html>
