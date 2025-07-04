<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Auth\GenericUser;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    function emailContainsStudent(string $email): bool
    {
        return str_contains($email, 'student');
    }

    public function authenticate(): \Illuminate\Http\RedirectResponse
    {
        $this->ensureIsNotRateLimited();
        $validated = $this->validated();

        $user = $validated['email'];
        $password = $validated['password'];
        $encodedPassword = base64_encode($password);

        try {
            $response = Http::withoutVerifying()
                ->withOptions([
                    'verify' => false,
                    'curl' => [
                        CURLOPT_SSLVERSION => 6,
                        CURLOPT_SSL_VERIFYHOST => 2,
                    ],
                ])
                ->get("https://student.pens.ac.id/confirmx.php", [
                    'user'  => $user,
                    'passwd' => $encodedPassword,
                ]);

            $body = trim($response->body());

            if ($body === "failed") {
                // Jika gagal login mahasiswa → coba login sebagai admin
                return $this->adminLogin(request());
            }

            session([
                'campus_user' => [
                    'email' => $user,
                    'nrp'  => explode("OK:", $body)[1],
                    'role' => 'user',
                ]
            ]);

            $name = explode('@', $user)[0];

            $response = Http::withHeaders([
                'x-api-key' => env('API_KEY'),
                'Accept'    => 'application/json',
            ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
                'table' => 'users',
                'filter' => ["email" => $user, "password" => bcrypt($encodedPassword)],
                'data'  => '*',
            ]);

            $userData = collect($response->json()['data'])
                ->firstWhere('EMAIL',  $user);
            if ($userData === null && $this->emailContainsStudent($user) && str_contains($body, 'OK:')) {
                $response = Http::withHeaders([
                    'x-api-key' => env('API_KEY'),
                    'Accept'    => 'application/json',
                ])->post('https://online.mis.pens.ac.id/API_PENS/v1/insert_up2k', [
                    'table' => 'users',
                    'data'  => [
                        [
                            "name" => $name,
                            "email" => $user,
                            "role" => "user",
                            "email_verified_at" => now()->format('d-M-y h.i.s A'),
                            "password" => bcrypt($encodedPassword),
                            "remember_token" => "",
                            "created_at" =>  now()->format('d-M-y h.i.s A'),
                            "updated_at" =>  now()->format('d-M-y h.i.s A'),
                        ]
                    ],
                ]);
                $json = $response->json();
                // dd($response->json());

                // Ambil item pertama dari data
                $data = collect($json['data'][0]);

                // Ambil bagian 'input' sebagai array
                $userData = $data->get('input');

                $user = User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => $userData['password'], // sudah bcrypt
                        'role' => $userData['role'],
                    ]
                );

                Auth::login($user, true);

                return redirect()->intended('/dashboard');
            }
            if ($userData["ROLE"] === 'admin') {
                return $this->adminLogin(request());
            }

            $user = new User([
                'email' => $userData['EMAIL'],
                'name' => $userData['NAME'],
                'password' => $userData['PASSWORD'], // Sudah dalam bentuk hash
                'role' => $userData['ROLE'],
            ]);

            $user->exists = true;

            Auth::login($user, false);

            RateLimiter::clear($this->throttleKey());

            // ✅ Tambahkan redirect setelah login sukses
            return redirect()->intended('/dashboard'); // ganti dengan route dashboard user
        } catch (\Exception $e) {
            RateLimiter::hit($this->throttleKey());
            // fallback ke admin login
            return $this->adminLogin(request());
        }
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $response = Http::withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ])->post('https://online.mis.pens.ac.id/API_PENS/v1/read_up2k', [
            'table' => 'users',
            'filter' => ['email' => $email],
            'data'  => '*',
        ]);

        if (! $response->successful()) {
            throw ValidationException::withMessages(['email' => 'Gagal menghubungi server autentikasi.']);
        }

        $userData = collect($response->json()['data'])->firstWhere('EMAIL', $email);

        if (! $userData) {
            throw ValidationException::withMessages(['email' => 'Email tidak ditemukan di sistem.']);
        }

        // ✅ Cek password API yang sudah dalam bentuk hash
        if (! Hash::check($password, $userData['PASSWORD'])) {
            throw ValidationException::withMessages(['password' => 'Password salah.']);
        }

        if ($userData['ROLE'] !== 'admin') {
            throw ValidationException::withMessages(['email' => 'Anda tidak memiliki akses sebagai admin.']);
        }

        // Sinkronisasi ke tabel users lokal
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $userData['NAME'] ?? 'Admin',
                'password' => bcrypt(Str::random(16)), // Password bisa acak karena tidak digunakan untuk autentikasi lokal
                'role' => $userData['ROLE'],
            ]
        );

        Auth::login($user, true); // Sekarang user adalah model User

        return redirect()->intended('admin/dashboard');
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }

    public function updateOrCreateUser(User $user) {}
}
