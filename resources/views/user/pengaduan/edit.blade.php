<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
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

        <h1 class="text-xl font-medium font-serif">Edit Pengaduan</h1>
        <hr class="horizontal dark mt-1 mb-2">

        <form method="POST" action="{{ route('user.pengaduan.update', encrypt($pengaduan->IDPENGADUAN)) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block font-medium text-gray-700 font-sans">Nama Lengkap</label>
            <input type="text" name="nama_pengadu" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('nama_pengadu', $pengaduan->NAMA_PENGADU) }}" required>

            <label class="block font-medium text-gray-700 font-sans">No. Telepon</label>
            <input type="text" name="no_telepon" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('no_telepon', $pengaduan->NO_TELEPON) }}" required>

            <label class="block font-medium text-gray-700 font-sans">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded-md mb-6"
                value="{{ old('email', $pengaduan->EMAIL) }}">

            <label class="block font-medium text-gray-700 font-sans">Nama Terlapor</label>
            <input type="text" name="nama_terlapor" class="w-full p-2 border rounded-md mb-4"
                value="{{ old('nama_terlapor', $pengaduan->NAMA_TERLAPOR) }}" required>

            <label class="block font-medium text-gray-700 font-sans">Tempat Kejadian</label>
            <input type="text" name="tmp_kejadian" class="w-full p-2 border rounded-md mb-6"
                value="{{ old('tmp_kejadian', $pengaduan->TMP_KEJADIAN) }}" required>

            <label class="block font-medium text-gray-700 font-sans">Tanggal Kejadian</label>
            <input type="date" name="tanggal_kejadian" class="w-full p-2 border rounded-md mb-6"
                value="{{ \Carbon\Carbon::createFromFormat('d-M-y', $pengaduan->TANGGAL_KEJADIAN)->format('Y-m-d') }}" required>

            <label class="block font-medium text-gray-700 font-sans">Detail Pengaduan</label>
            <textarea name="detail" class="w-full p-3 border rounded mt-2" rows="4" required>{{ old('detail', $pengaduan->DETAIL) }}</textarea>

            <label class="block font-medium text-gray-700 font-sans mt-4">
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

            @if ($pengaduan->BUKTI)
                <p class="text-sm text-gray-700 mt-2">
                    <strong>Bukti saat ini:</strong>
                    <a href="{{ asset('storage/' . $pengaduan->BUKTI) }}" target="_blank"
                        class="text-blue-600 underline">Lihat Bukti</a>
                </p>
            @endif

            <!-- Modal Info -->
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
                    <button type="button" onclick="document.getElementById('infoModal').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-3xl p-2">
                        &times;
                    </button>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('user.pengaduan.list') }}"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                    Kembali
                </a>
                <button class="mt-5 bg-purple-600 text-white py-2 px-5 rounded">Perbarui Pengaduan</button>
            </div>
        </form>
    </div>

    <script>
        setTimeout(() => {
            const modal = document.getElementById('successModal');
            if (modal) modal.remove();
        }, 3000);
    </script>

</x-app-layout>
