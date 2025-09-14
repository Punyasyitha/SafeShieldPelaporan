{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'SafeShield — PENS') }}</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-yBFgZMR3+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-b from-fuchsia-50 via-white to-white text-purple-900 antialiased">
  {{-- glow background --}}
  <div aria-hidden="true" class="fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-36 -left-28 h-[28rem] w-[36rem] rounded-full bg-fuchsia-300/55 blur-3xl"></div>
    <div class="absolute top-28 right-24 h-44 w-44 rounded-full bg-fuchsia-300/40 blur-2xl"></div>
    <div class="absolute -bottom-40 left-1/3 h-[32rem] w-[42rem] rounded-full bg-purple-300/40 blur-3xl"></div>
  </div>

  <main class="min-h-screen flex items-center py-10 px-4">
    <div class="container mx-auto max-w-7xl">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        {{-- SLOT FORM (glassy card, lebih lebar) --}}
        <div class="w-full max-w-[480px] mx-auto lg:mx-0 rounded-3xl
                    bg-white/80 backdrop-blur border border-purple-900/10
                    shadow-xl p-8 md:p-10">
          {{ $slot }}
        </div>

        {{-- PANEL ANIMASI (match landing) --}}
        <div class="hidden lg:block">
          <div class="relative overflow-hidden rounded-3xl p-10
                      bg-gradient-to-br from-fuchsia-500 to-purple-600
                      ring-1 ring-purple-900/10 shadow-2xl text-white">
            <div class="absolute -inset-10 -z-10 rounded-full bg-purple-300/30 blur-3xl"></div>

            <div class="mx-auto grid place-items-center w-64 h-64 md:w-72 md:h-72 rounded-full
                        bg-gradient-to-br from-fuchsia-500 to-purple-600
                        ring-8 ring-white/20 shadow-[0_30px_80px_rgba(147,51,234,0.35)]
                        animate-float transform-gpu will-change-transform">
              <span class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                           h-48 w-48 rounded-full ring-8 ring-white/15 animate-ripple"></span>
              <span class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                           h-64 w-64 rounded-full ring-8 ring-white/10
                           animate-[ripple_3.2s_ease-out_1.2s_infinite]"></span>
              <svg class="absolute h-[115%] w-[115%] text-white/20 animate-[slowspin_20s_linear_infinite]"
                   viewBox="0 0 100 100" fill="none" aria-hidden="true">
                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="2"/>
              </svg>
              <div class="grid place-items-center h-24 w-24 rounded-full bg-white/10 ring-8 ring-white/25 backdrop-blur">
                <svg class="h-12 w-12 text-white/95 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>
                </svg>
              </div>
            </div>

            <p class="mt-8 text-center text-white/90 text-lg max-w-2xl mx-auto">
              “Tidak ada alasan untuk kekerasan, tidak ada pembenaran untuk pelecehan.
              Semua orang berhak merasa aman.”
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
