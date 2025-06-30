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

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function loginToStudentPens()
    {
        $user   = 'masyitharala@it.student.pens.ac.id';
        $passwd = base64_encode('Mahasiswi22');

        $response = Http::withoutVerifying() // disable SSL verification (not recommended for production)
            ->withOptions([
                'verify' => false,
                'curl' => [
                    CURLOPT_SSLVERSION => 6,
                    CURLOPT_SSL_VERIFYHOST => 2,
                ],
            ])
            ->get("https://student.pens.ac.id/confirmx.php", [
                'user'   => $user,
                'passwd' => $passwd,
            ]);

        // Tampilkan hasil response
        dd($response->body());
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $validated = $this->validated();

        $user = $validated['email']; // ganti jadi user
        $password = $validated['password']; // ganti jadi password
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
                    'user'   => $user,
                    'passwd' => $encodedPassword,
                ]);

            $body = trim($response->body());

            // Jika gagal login
            if ($body === "failed") {
                RateLimiter::hit($this->throttleKey());
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            // Jika berhasil, simpan session
            session([
                'campus_user' => [
                    'email' => $user,
                    'nrp'   => explode("OK:", $body)[1],
                    'role'  => 'user',
                ]
            ]);


            // Fix: ini get nama user dari email
            // Misal : masyitharala@it.student.pens.ac.id --> masyitharala
            $name = explode('@', $user)[0];

            // Cari user di db berdasarkan email
            // Jika tidak ada, buat user baru
            $createdUser = User::firstOrCreate(
                ['email' => $user],
                [
                    'name' => $name,
                    'nrp'  => explode("OK:", $body)[1],
                    'role' => 'user',
                    'password' => Hash::make($password),
                ]
            );

            // Melakukan authentication laravel dari user yang sudah dibuat/dicari
            if (Auth::attempt(['email' => $user, 'password' => $password])) {
                Auth::login($createdUser, true);
            }

            RateLimiter::clear($this->throttleKey());
        } catch (\Exception $e) {
            RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }

    protected function throwIfKnownError(string $response)
    {
        $trimmed = strtolower(trim($response));

        $knownErrors = [
            'failed' => [
                'message' => 'Username atau password salah, silakan cek kembali',
                'code' => 401,
            ],
            'username atau password salah' => [
                'message' => 'Username atau password salah, silakan cek kembali',
                'code' => 401,
            ],
            'error' => [
                'message' => 'Internal server error',
                'code' => 500,
            ],
            'internal server error' => [
                'message' => 'Internal server error',
                'code' => 500,
            ],
        ];

        if (isset($knownErrors[$trimmed])) {
            $error = $knownErrors[$trimmed];
            throw new \Exception($error['message'], $error['code']);
        }
    }
    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
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

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}