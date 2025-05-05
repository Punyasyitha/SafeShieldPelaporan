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
            <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <!-- Modal Box -->
                <div class="bg-white rounded-lg p-6 shadow-lg max-w-sm w-full relative">
                    <button onclick="document.getElementById('successModal').remove()"
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

        @if (session('error'))
            <div class="alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Gagal! </strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <h1 class="text-xl font-medium font-serif">1. Lengkapi Identitas Anda</h1>
        <p class="text-gray-600 mb-4 font-sans">
            Lengkapi identitas diri Anda untuk mempermudah verifikasi data atas pengaduan Anda.
        </p>

        <form method="POST" action="{{ route('user.pengaduan.store') }}" enctype="multipart/form-data">
            @csrf

            <label class="block font-medium text-gray-700 font-sans">Nama Lengkap</label>
            <input type="text" name="nama_pengadu" class="w-full p-2 border rounded-md mb-4"
                placeholder="Nama Lengkap Anda" required>

            <label class="block font-medium text-gray-700 font-sans">No. Telepon</label>
            <input type="text" name="no_telepon" class="w-full p-2 border rounded-md mb-4"
                placeholder="08xx-xxxx-xxxx" required>

            <label class="block font-medium text-gray-700 font-sans">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded-md mb-6" placeholder="@gmail.com">

            <h1 class="text-xl font-medium font-serif">2. Detail Pengaduan</h1>
            <p class="text-gray-600 mb-4 font-sans">Sampaikan laporan Anda secara detail dan jelas.</p>

            <label class="block font-medium text-gray-700 font-sans">Nama Terlapor</label>
            <input type="text" name="nama_terlapor" class="w-full p-2 border rounded-md mb-4"
                placeholder="Nama Pihak yang Dilaporkan" required>

            <label class="block font-medium text-gray-700 font-sans">Tempat Kejadian</label>
            <input type="text" name="tmp_kejadian" class="w-full p-2 border rounded-md mb-6"
                placeholder="Tempat Kejadian Perkara" required>

            <label class="block font-medium text-gray-700 font-sans">Tanggal Kejadian</label>
            <input type="date" name="tanggal_kejadian" class="w-full p-2 border rounded-md mb-6" required>

            <label class="block font-medium text-gray-700 font-sans">Detail Pengaduan</label>
            <textarea name="detail" class="w-full p-3 border rounded mt-2" rows="4" placeholder="Detail Pengaduan" required></textarea>

            <label class="block font-medium text-gray-700 font-sans">
                Bukti Pendukung
                <button type="button" onclick="document.getElementById('infoModal').classList.remove('hidden')"
                    class=" text-black hover:text-black">
                    <i class="fa-solid fa-circle-info"></i>
                </button>
            </label>

            <input type="file" name="bukti" class="block mt-2">
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

            {{-- <div class="mt-4">
                <label class="block font-medium text-gray-700 font-sans">Kode Keamanan</label>
                <div class="flex items-center space-x-3">
                    <span>{!! Captcha::img() !!}</span>
                    <button type="button" id="refresh-captcha" class="bg-gray-300 p-1 rounded">🔄</button>
                </div>
                <input type="text" name="captcha" class="w-full p-2 border rounded-md mt-2"
                    placeholder="Masukkan kode di atas" required>
            </div> --}}

            <button class="mt-5 bg-purple-600 text-white py-2 px-5 rounded">Kirim Pengaduan</button>
        </form>
    </div>

    <script>
        // document.getElementById('refresh-captcha').addEventListener('click', function() {
        //     fetch('/refresh-captcha')
        //         .then(response => response.json())
        //         .then(data => {
        //             document.querySelector('span img').src = data.captcha;
        //         })
        //         .catch(error => console.error('Error refreshing captcha:', error));
        // });

        // Auto-hide alert setelah 3 detik
        // setTimeout(() => {
        //     document.querySelectorAll('.alert').forEach(alert => {
        //         alert.style.transition = "opacity 0.5s ease-out";
        //         alert.style.opacity = "0";
        //         setTimeout(() => alert.remove(), 500); // Hapus elemen setelah efek fade-out selesai
        //     });
        // }, 3000);
        setTimeout(() => {
            const modal = document.getElementById('successModal');
            if (modal) modal.remove();
        }, 3000);
    </script>


</x-app-layout>
