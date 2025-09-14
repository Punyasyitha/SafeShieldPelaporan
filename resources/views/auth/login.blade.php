{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
  <h1 class="text-2xl font-extrabold tracking-tight">Masuk ke SafeShield</h1>
  <p class="mt-1 text-sm text-slate-600">Gunakan akun PENS Anda.</p>

  <x-auth-session-status class="mt-4 mb-2" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-5">
    @csrf

    {{-- Email --}}
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"
        class="block mt-1 w-full appearance-none rounded-xl
               bg-white text-gray-900 placeholder:text-slate-400
               ring-1 ring-purple-900/10 focus:outline-none
               focus:ring-2 focus:ring-fuchsia-500 focus:border-fuchsia-500
               shadow-sm" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div class="relative">
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" name="password" type="password" required autocomplete="current-password"
        class="block mt-1 w-full appearance-none rounded-xl pr-10
               bg-white text-gray-900 placeholder:text-slate-400
               ring-1 ring-purple-900/10 focus:outline-none
               focus:ring-2 focus:ring-fuchsia-500 focus:border-fuchsia-500
               shadow-sm" />
      <button type="button" class="absolute right-3 top-10 text-slate-500 hover:text-slate-700"
              onclick="togglePassword()" aria-label="Show/Hide password">
        <i id="eyeIcon" class="fas fa-eye"></i>
      </button>
      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Remember --}}
    <label for="remember_me" class="inline-flex items-center gap-2">
      <input id="remember_me" type="checkbox"
             class="rounded border-slate-300 text-fuchsia-600 shadow-sm focus:ring-fuchsia-500"
             name="remember">
      <span class="text-sm text-slate-600">Remember me</span>
    </label>

    {{-- Aksi --}}
    <div class="space-y-3">
      <x-primary-button
        class="w-full justify-center normal-case rounded-2xl px-6 py-3
               bg-gradient-to-r from-fuchsia-600 to-purple-600
               text-white ring-1 ring-white/20 shadow-lg hover:opacity-95">
        {{ __('Log in') }}
      </x-primary-button>

      <a href="{{ url('/') }}" class="block text-center text-sm text-slate-600 hover:text-purple-900 underline underline-offset-4">
        Kembali ke Beranda
      </a>
    </div>
  </form>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const eye   = document.getElementById('eyeIcon');
      const show  = input.type === 'password';
      input.type  = show ? 'text' : 'password';
      eye.classList.toggle('fa-eye', !show);
      eye.classList.toggle('fa-eye-slash', show);
    }
  </script>
</x-guest-layout>
