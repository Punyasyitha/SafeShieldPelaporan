<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        {{-- @if (session('success'))
            <div class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Sukses! </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif --}}
        @if (session('success'))
            <!-- Modal Background -->
            <div id="successModal" class="fixed inset-0 z-[2000] bg-black/50 flex items-center justify-center" x-data
                x-init="setTimeout(() => $el.remove(), 4000)"> {{-- auto-close 4 detik --}}
                <div class="bg-white rounded-lg p-6 shadow-lg max-w-sm w-full relative">
                    <button @click="$root.remove()"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        <div>
                            <p class="font-bold text-green-700">Sukses!</p>
                            <p class="text-gray-700 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <!-- Modal Background -->
            <div id="validationErrorModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <!-- Modal Box -->
                <div class="bg-white rounded-lg p-6 shadow-lg max-w-sm w-full relative">
                    <button onclick="document.getElementById('validationErrorModal').remove()"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mt-1"></i>
                        <div>
                            <p class="font-bold text-yellow-700">Validasi Gagal!</p>
                            <ul class="text-gray-700 text-sm list-disc pl-5 space-y-1 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <h1 class="text-xl font-medium font-serif">1. Lengkapi Identitas Anda</h1>
        <p class="text-gray-600 mb-4 font-sans">
            Lengkapi identitas diri Anda untuk mempermudah verifikasi data atas pengaduan Anda.
        </p>

        <form method="POST" action="{{ route('user.pengaduan.store') }}" enctype="multipart/form-data"
            x-data="{ sending: false }" @submit="if ($el.checkValidity()) { sending = true }">
            @csrf

            <label class="block font-medium text-gray-700 font-sans">Nama Lengkap</label>
            <input type="text" name="nama_pengadu" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('nama_pengadu') }}" placeholder="Nama Lengkap Anda" required>

            <label class="block font-medium text-gray-700 font-sans">No. Telepon</label>
            <input type="text" name="no_telepon" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('no_telepon') }}" placeholder="08xx-xxxx-xxxx" required>

            <label class="block font-medium text-gray-700 font-sans">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded-md mb-6" value="{{ old('email') }}">

            <h1 class="text-xl font-medium font-serif">2. Detail Pengaduan</h1>
            <p class="text-gray-600 mb-4 font-sans">Sampaikan laporan Anda secara detail dan jelas.</p>

            <label class="block font-medium text-gray-700 font-sans">Nama Terlapor</label>
            <input type="text" name="nama_terlapor" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('nama_terlapor') }}" placeholder="Nama Pihak yang Dilaporkan" required>

            <label class="block font-medium text-gray-700 font-sans">Tempat Kejadian</label>
            <input type="text" name="tmp_kejadian" class="w-full p-2 border rounded-md mb-6"
                value="{{ old('tmp_kejadian') }}" placeholder="Tempat Kejadian Perkara" required>

            <label class="block font-medium text-gray-700 font-sans">Tanggal Kejadian</label>
            <input type="date" name="tanggal_kejadian" class="w-full p-2 border rounded-md mb-6"
                value="{{ old('tanggal_kejadian') }}" required>

            <label class="block font-medium text-gray-700 font-sans">Detail Pengaduan</label>
            <textarea name="detail" class="w-full p-3 border rounded mt-2" rows="4" placeholder="Detail Pengaduan" required>{{ old('detail') }}</textarea>

            <label class="block font-medium text-gray-700 font-sans">
                Bukti Pendukung
                <button type="button" onclick="document.getElementById('infoModal').classList.remove('hidden')"
                    class=" text-black hover:text-black">
                    <i class="fa-solid fa-circle-info"></i>
                </button>
            </label>

            <input id="bukti" name="bukti" type="file"
                class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-fuchsia-600 file:px-4 file:py-2 file:text-white hover:file:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50"
                accept=".png,.jpg,.jpeg,.pdf,.mp4,.mp3,.wav, image/png,image/jpeg,application/pdf,video/mp4, audio/mpeg,audio/wav,audio/x-wav,audio/wave">

            {{-- Tampilkan error khusus field bukti --}}
            @error('bukti')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-600">
                File yang diizinkan: pdf, jpg, png, mp4, mp3 (maks 5MB).
            </p>

            <!-- Modal Pop-up -->
            <div id="infoModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-xl p-6 relative">
                    <h2 class="text-lg font-semibold mb-4">Informasi Bukti Pendukung</h2>
                    <p class="text-sm text-gray-700">
                        <strong>1. 1-7 Hari Pasca Kejadian</strong> - Bukti berupa Foto (PNG dan JPG), Video (MP4), dan
                        Rekaman Suara (MP3), dengan catatan:<br>
                        A. Video dalam bentuk visual dan audio berisi kejadian saat tindakan berlangsung atau aktivitas
                        terlapor.<br>
                        B. Rekaman suara dari pihak saksi atau korban berisi kejadian saat tindakan berlangsung.<br>
                        <strong>2. 14 Hari Pasca Kejadian</strong> - Bukti berupa hasil pemeriksaan visum korban atau
                        dokumen lain yang dikonversi ke dalam bentuk PDF.
                    </p>
                    <button onclick="document.getElementById('infoModal').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl p-2">
                        &times;
                    </button>
                </div>
            </div>

            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}

            {{-- <div class="mt-4">
                <label class="block font-medium text-gray-700 font-sans">Kode Keamanan</label>
                <div class="flex items-center space-x-3">
                    <span>{!! Captcha::img() !!}</span>
                    <button type="button" id="refresh-captcha" class="bg-gray-300 p-1 rounded">🔄</button>
                </div>
                <input type="text" name="captcha" class="w-full p-2 border rounded-md mt-2"
                    placeholder="Masukkan kode di atas" required>
            </div> --}}

            {{-- <button class="mt-5 bg-purple-600 text-white py-2 px-5 rounded">Kirim Pengaduan</button> --}}
            {{-- Tombol submit + status --}}
            <button type="submit" :disabled="sending"
                class="mt-5 inline-flex items-center gap-2 rounded bg-fuchsia-600 px-5 py-2 text-white
                     hover:bg-fuchsia-700 focus:outline-none focus:ring-2 focus:ring-fuchsia-500/50
                     disabled:opacity-60 disabled:cursor-not-allowed transition">
                <svg x-cloak x-show="sending" class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none"
                    aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                </svg>
                <span x-show="!sending">Kirim Pengaduan</span>
                <span x-cloak x-show="sending">Mengirim…</span>
            </button>

            {{-- Overlay opsional --}}
            <div x-cloak x-show="sending"
                class="fixed inset-0 z-[60] bg-black/30 backdrop-blur-sm grid place-items-center" aria-live="polite">
                <div class="rounded-xl bg-white px-5 py-3 shadow ring-1 ring-black/10 text-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                        </svg>
                        <span>Data sedang dikirim. Mohon tunggu…</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        setTimeout(() => {
            const modal = document.getElementById('successModal');
            if (modal) modal.remove();
        }, 3000);

        public

        function rules() {
            return [
                ...
                // kode di bawah ini yang kalian tambahkan
                'g-recaptcha-response' => ['required', 'captcha']
            ];
        }

        // atau jika kalian tidak menggunakan form request
        // dan langsung melakukan validasi di controller
        // menggunakan Validator class, bisa lihat kode di bawah ini

        $validate = Validator::make(Input::all(), [
            ...
            // kode di bawah ini yang kalian tambahkan
            'g-recaptcha-response' => 'required|captcha'
        ]);
    </script>


</x-app-layout>
