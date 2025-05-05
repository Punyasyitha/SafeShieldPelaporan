<x-app-layout>
    <div class="container mx-auto py-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-800">SAFE<span class="text-purple-400">SHIELD</span>
                    <p class="text-sm text-gray-600">Selamat datang di halaman dashboard SHAFESHIELD!</p>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @php
                $stats = [
                    [
                        'label' => 'Status Baru',
                        'value' => $statusBaru,
                        'icon' => 'fas fa-check-circle',
                        'color' => 'from-green-700 via-green-400 to-yellow-200',
                    ],
                    [
                        'label' => 'Modul Baru',
                        'value' => $modulBaru,
                        'icon' => 'fas fa-server',
                        'color' => 'from-blue-900 via-blue-400 to-gray-300',
                    ],
                    [
                        'label' => 'Kategori Baru',
                        'value' => $kategoriBaru,
                        'icon' => 'fas fa-layer-group',
                        'color' => 'from-yellow-900 via-yellow-400 to-red-500',
                    ],
                    [
                        'label' => 'Penulis Baru',
                        'value' => $penulisBaru,
                        'icon' => 'fas fa-pen-to-square',
                        'color' => 'from-pink-700 via-blue-400 to-pink-300',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">{{ $stat['label'] }}</p>
                            <h5 class="text-xl font-bold text-gray-800">+{{ $stat['value'] }}</h5>
                            <p class="text-xs text-green-600 font-semibold">+0% <span class="text-gray-500">bulan
                                    ini</span></p>
                        </div>
                        <div class="bg-gradient-to-tr {{ $stat['color'] }} p-3 rounded-full">
                            <i class="{{ $stat['icon'] }} text-white"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Grid 2 kolom seperti biasa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

            <!-- Bar Chart -->
            <div class="bg-white shadow rounded-lg">
                <div class="p-4 border-b">
                    <h6 class="font-semibold text-gray-800">Banyak Pengaduan yang Telah Diterima</h6>
                    <p class="text-sm text-gray-500">Data diperbarui per {{ now()->translatedFormat('d F Y') }}</p>
                </div>
                <div class="p-4">
                    <div class="relative h-64"> <!-- Tinggi div kontrol di sini -->
                        <canvas id="bar-chart" class="absolute inset-0 w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="bg-white shadow rounded-lg">
                <div class="p-4 border-b">
                    <h6 class="font-semibold text-gray-800">Pengaduan Berdasarkan Status</h6>
                    <p class="text-sm text-gray-500">Data diperbarui per {{ now()->translatedFormat('d F Y') }}</p>
                </div>
                <div class="p-4">
                    <div class="relative h-60"> <!-- Sedikit lebih pendek dari bar chart -->
                        <canvas id="pie-chart" class="absolute inset-0 w-full h-full"></canvas>
                    </div>
                    <div class="text-center mt-4">
                        <button id="show-others" class="text-blue-600 hover:underline text-sm">Lihat Others...</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kurs dan Progress -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div class="bg-gradient-to-r from-purple-400 to-blue-400 text-white p-4 rounded-lg shadow">
                <h6 class="uppercase text-sm font-bold">Website SPADA</h6>
                <a href="https://datacenter.ortax.org/ortax/kursbi/list" target="_blank"
                    class="inline-block mt-2 bg-white text-blue-600 px-4 py-2 rounded shadow">
                    Lihat SPADA
                </a>
            </div>
            <div class="bg-gradient-to-r from-purple-400 to-blue-400 text-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="uppercase text-sm font-bold">Pengaduan Telah Selesai Periode Satu Bulan</p>
                        <h5 class="text-2xl font-bold">{{ $selesaiBulanIni }}</h5>
                    </div>
                    <div class="w-1/3">
                        <div class="bg-white h-2 rounded-full">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $progresSelesai }}%"></div>
                        </div>
                        <p class="text-xs mt-1 text-right">{{ $progresSelesai }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        const barCtx = document.getElementById('bar-chart');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($barChart->pluck('tanggal')) !!}, // Ubah 'bulan' jadi 'tanggal'
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: {!! json_encode($barChart->pluck('total')) !!},
                    backgroundColor: 'rgb(214, 154, 222)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Angka bulat
                        }
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pie-chart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($pieChart->pluck('nama_status')) !!},
                datasets: [{
                    data: {!! json_encode($pieChart->pluck('total')) !!},
                    backgroundColor: ['#8F87F1', '#C68EFD', '#E9A5F1', '#FED2E2', '#FFD0C7']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });
    </script>
</x-app-layout>
