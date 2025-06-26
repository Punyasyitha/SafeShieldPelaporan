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

        <div class="w-full overflow-x-auto">
            <table class="table-fixed text-sm text-left border-gray-200" id="pengaduanUserTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 min-w-[50px] truncate">No</th>
                        <th class="py-3 px-2 min-w-[100px] truncate">Proses</th>
                        <th class="py-3 px-2 min-w-[100px] truncate">Tanggal Kejadian</th>
                        <th class="py-3 px-2 min-w-[120px] truncate">Nama Terlapor</th>
                        <th class="py-3 px-2 min-w-[120px] truncate">Tempat Kejadian</th>
                        <th class="py-3 px-2 min-w-[120px] truncate">Detail</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Keterangan</th>
                        <th class="py-3 px-2 min-w-[100px] truncate">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($list) > 0)
                        @foreach ($list as $item)
                            @php
                                $status = $item->nama_status ?? '-';
                                $class = $warnaStatus[$status] ?? 'bg-gray-200 text-gray-800';
                            @endphp
                            <tr class="border-t border-gray-200">
                                <td class="py-3 px-2">{{ $loop->iteration }}</td>
                                <td class="py-3 px-2 truncate">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 truncate">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-2 truncate">{{ $item->nama_terlapor }}</td>
                                <td class="py-3 px-2">{{ $item->tmp_kejadian }}</td>
                                <td class="py-3 px-2 truncate">{{ Str::limit(strip_tags($item->detail), 50) }}</td>
                                <td class="py-3 px-2">{{ Str::limit(strip_tags($item->keterangan), 50) }}</td>
                                <td class="py-3 px-2">
                                    <div class="flex flex-wrap gap-2" x-data="{ open: false }">
                                        @if ($status === 'Verifikasi')
                                            <button
                                                class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                                onclick="window.location='{{ route('user.pengaduan.edit', encrypt($item->idpengaduan)) }}'">
                                                Edit
                                            </button>
                                        @else
                                            <button @click="open = true"
                                                class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2">
                                                Lihat
                                            </button>
                                        @endif

                                        <!-- Modal -->
                                        <div x-show="open" x-transition x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-20">
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
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tableRows = document.querySelectorAll('#pengaduanUserTable tbody tr');

                searchInput.addEventListener('input', function() {
                    const searchTerm = searchInput.value.toLowerCase();

                    tableRows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        const match = rowText.includes(searchTerm);
                        row.style.display = match ? '' : 'none';
                    });
                });
            });
            $(document).ready(function() {
                $('#pengaduanUserTable').DataTable({
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
                        zeroRecords: "Belum ada laporan pengaduan",
                        infoEmpty: "Menampilkan 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)"
                    }
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
