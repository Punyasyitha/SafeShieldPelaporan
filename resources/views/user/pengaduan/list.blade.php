<x-app-layout>
    <div class="w-full bg-white shadow rounded-lg p-6 mt-6">
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-2">Daftar Pengaduan Saya</h2>
            <p class="text-sm text-gray-500">Berikut adalah pengaduan yang telah Anda ajukan. Anda dapat melihat detail
                atau status dari setiap laporan.</p>
        </div>

        @if (session('success'))
            <div class="alert bg-green-100 border border-green-400 text-green-700 px-2 py-3 rounded mb-4" role="alert">
                <strong>Sukses! </strong>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert bg-red-100 border border-red-400 text-red-700 px-2 py-3 rounded mb-4" role="alert">
                <strong>Gagal! </strong>{{ session('error') }}
            </div>
        @endif

        {{-- Tombol Tambah & Pencarian --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
            <input type="text" id="searchInput" placeholder="Cari pengaduan..."
                class="border border-gray-300 rounded-lg py-2 px-2 focus:outline-none focus:ring-2 focus:ring-purple-200 w-full md:w-1/3">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-gray-200" id="pengaduanUserTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 min-w-[50px] ">No</th>
                        <th class="py-3 px-2 min-w-[100px] ">Status</th>
                        <th class="py-3 px-2 min-w-[100px] ">Tanggal Kejadian</th>
                        <th class="py-3 px-2 min-w-[120px] ">Nama Terlapor</th>
                        <th class="py-3 px-2 min-w-[120px] ">Tempat Kejadian</th>
                        <th class="py-3 px-2 min-w-[120px] ">Detail</th>
                        <th class="py-3 px-2 min-w-[150px] ">Keterangan</th>
                        <th class="py-3 px-2 min-w-[100px] ">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $item)
                        <tr class="border-t border-gray-200">
                            <td class="py-3 px-2 ">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 ">
                                @php
                                    $status = $item->nama_status ?? '-';
                                    $class = $warnaStatus[$status] ?? 'bg-gray-200 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="py-3 px-2 ">
                                {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y') }}
                            </td>
                            <td class="py-3 px-2 ">{{ $item->nama_terlapor }}</td>
                            <td class="py-3 px-2 ">{{ $item->tmp_kejadian }}</td>
                            <td class="py-3 px-2 ">{{ Str::limit(strip_tags($item->detail), 60) }}</td>
                            <td class="py-3 px-2 ">{{ Str::limit(strip_tags($item->keterangan), 60) }}</td>
                            <td class="py-3 px-2">
                                <div class="flex flex-wrap gap-2" x-data="{ open: false }">
                                    @if ($status === 'Verifikasi')
                                        <!-- Tombol Edit -->
                                        <button
                                            class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                            onclick="window.location='{{ route('user.pengaduan.edit', encrypt($item->idpengaduan)) }}'">
                                            Edit
                                        </button>
                                    @else
                                        <!-- Tombol Lihat -->
                                        <button @click="open = true"
                                            class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2">
                                            Lihat
                                        </button>
                                    @endif

                                    <!-- Modal -->
                                    <div x-show="open" x-transition x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
                                        <div @click.away="open = false"
                                            class="bg-white rounded-lg p-6 w-[90%] max-w-xl overflow-y-auto max-h-[90vh]">
                                            <h2 class="text-xl font-bold mb-4 text-purple-600">Detail Pengaduan</h2>
                                            <div class="space-y-3 text-sm text-gray-700">
                                                <div>
                                                    <span class="font-semibold">Status:</span>
                                                    <span
                                                        class="ml-2 px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                                        {{ $status }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Tanggal Kejadian:</span>
                                                    {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y') }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Nama Terlapor:</span>
                                                    {{ $item->nama_terlapor }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Tempat Kejadian:</span>
                                                    {{ $item->tmp_kejadian }}
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Detail Kejadian:</span>
                                                    <div class="border p-2 mt-1 rounded bg-gray-50">
                                                        {!! nl2br(e($item->detail)) !!}
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="font-semibold">Keterangan:</span>
                                                    <div class="border p-2 mt-1 rounded bg-gray-50">
                                                        {!! nl2br(e($item->keterangan)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-6 text-right">
                                                <button @click="open = false"
                                                    class="px-2 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#pengaduanUserTable').DataTable({
                    searching: false, // matikan fitur pencarian
                    responsive: true,
                    language: {
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        },
                        zeroRecords: "Tidak ada data yang cocok",
                        infoEmpty: "Menampilkan 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)"
                    }
                });
            });

            // Fitur Pencarian
            document.getElementById('searchInput').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#pengaduanUserTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
                });
            });

            // Auto-hide alert
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.transition = "opacity 0.5s";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000);
        </script>
    @endpush
</x-app-layout>
