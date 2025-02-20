<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Selamat Datang, Admin!
        </h2>
        <p class="text-gray-600 text-sm mt-1">
            Selamat datang di halaman dashboard admin. Kelola pelaporan dan modul edukasi pada website ini.
        </p>
    </x-slot>

    <div class=" px-4 sm:px-6 lg:px-8 bg-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kartu Statistik Pengaduan -->
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700">Total Pengaduan</h3>
                <p class="text-4xl font-bold text-purple-600 mt-2">120</p>
                <p class="text-gray-500 text-sm mt-1">Pengaduan masuk bulan ini</p>
            </div>

            <!-- Kartu Statistik Pengaduan Diproses -->
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700">Pengaduan Diproses</h3>
                <p class="text-4xl font-bold text-blue-600 mt-2">45</p>
                <p class="text-gray-500 text-sm mt-1">Sedang dalam tahap penanganan</p>
            </div>

            <!-- Kartu Statistik Pengaduan Selesai -->
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700">Pengaduan Selesai</h3>
                <p class="text-4xl font-bold text-green-600 mt-2">75</p>
                <p class="text-gray-500 text-sm mt-1">Telah diselesaikan</p>
            </div>
        </div>

        <!-- Bagian Data Pengaduan Terbaru -->
        <div class="mt-5 bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengaduan Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-purple-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left">Nama Pelapor</th>
                            <th class="py-3 px-4 text-left">Tanggal Pengaduan</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-200">
                        <tr>
                            <td class="py-3 px-4">Andi Wijaya</td>
                            <td class="py-3 px-4">20 Februari 2025</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Verifikasi</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="#" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">Siti Aminah</td>
                            <td class="py-3 px-4">18 Februari 2025</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Selesai</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="#" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
