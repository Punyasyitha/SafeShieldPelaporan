{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
</head>

<body class="g-sidenav-show" style="background-color: #FFF;">
    <main class="main-content mt-0 ps">
        <section>
            <div class="page-header min-vh-100">
                <div class="container-fluid vh-100">
                    <div class="row h-100 d-flex align-items-center justify-content-center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Bagian Kiri: Form Sign In -->
                        <div class="col-lg-4 col-md-7 mx-auto">
                            <div class="card card-plain p-4"
                                style="background-color: #FFF; border: none; box-shadow: none;">
                                <div class="card-header pb-3 text-start" style="background-color: #FFF;">
                                    <h4 class="font-weight-bolder text-center"style="font-family: 'Playfair Display', sans-serif;
                                        font-size: 28px; font-weight: 700; color: #333;">
                                        Get Started Now</h4>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" value="{{ old('email') }}" name="email"
                                                class="form-control form-control-lg" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                required>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0"
                                                style="background-color: #DD88CF; border: 2px solid #DD88CF; color: #fff;">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan: Gambar -->
                        <div class="col-lg-6 d-none d-lg-flex p-0" style="height: 100vh;">
                            <div class="position-relative w-100 h-100 overflow-hidden d-flex flex-column align-items-center justify-content-center"
                                style="background-image: url('{{ asset('assets/images/Background.png') }}');
                                    background-size: cover; background-position: center; background-repeat: no-repeat; height: 100%; width: 100%;">

                                <!-- 🔥 Overlay Transparan -->
                                <div
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                        background-image: url('{{ asset('assets/images/Vector.png') }}');
                                            background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 0.7; z-index: 1;">
                                </div>

                                <!-- ✨ Konten Teks -->
                                <div class="text-center text-white" style="z-index: 2;">
                                    <h3 class="font-weight-bolder">"Attention is the new currency"</h3>
                                    <p>The more effortless the writing looks, the more effort the writer actually put
                                        into the process.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
