<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        @if (session('success'))
            <div class="alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Sukses! </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
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
            <input type="text" name="no_telepon" class="w-full p-2 border rounded-md mb-4" placeholder="08xx-xxxx-xxxx"
                required>

            <label class="block font-medium text-gray-700 font-sans">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded-md mb-6" placeholder="@gmail.com"
                required>

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
            <textarea name="detail" class="w-full p-3 border rounded mt-2" rows="4"
                placeholder="Detail Pengaduan" required></textarea>

            <label class="block font-medium text-gray-700 font-sans">Bukti Pendukung</label>
            <input type="file" name="bukti" class="block mt-2">
            <p class="text-sm text-gray-600">
                File yang diizinkan: pdf, jpg, png, mp4, mp3 (maks 5MB).
            </p>

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
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s ease-out";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah efek fade-out selesai
            });
        }, 3000);
    </script>


</x-app-layout>
