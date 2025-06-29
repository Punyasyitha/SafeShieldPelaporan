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

        {{-- Tombol Pencarian --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
            <input type="text" id="searchInput" placeholder="Search..."
                class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-purple-200 w-full md:w-1/3">
        </div>

        <div class="overflow-x-auto">
            <table class="table-fixed w-full text-sm text-left border-gray-200" id="pengaduanUserTable">
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
                        @foreach ($list as $index => $item)
                            @php
                                $status = $item['NAMA_STATUS'] ?? '-';
                                $class = $warnaStatus[$status] ?? 'bg-gray-200 text-gray-800';
                            @endphp
                            <tr class="border-t border-gray-200">
                                <td class="py-3 px-2">{{ $index + 1 }}</td>
                                <td class="py-3 px-2 truncate">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 truncate">
                                    {{ \Carbon\Carbon::parse($item['TANGGAL_KEJADIAN'] ?? '-')->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-2 truncate">{{ $item['NAMA_TERLAPOR'] ?? '-' }}</td>
                                <td class="py-3 px-2">{{ $item['TMP_KEJADIAN'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">{{ Str::limit(strip_tags($item['DETAIL'] ?? '-'), 50) }}
                                </td>
                                <td class="py-3 px-2">{{ Str::limit(strip_tags($item['KETERANGAN'] ?? '-'), 50) }}</td>
                                <td class="py-3 px-2">
                                    <div class="flex flex-wrap gap-2" x-data="{ open: false }">
                                        @if ($status === 'Verifikasi')
                                            <button
                                                class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                                onclick="window.location='{{ route('user.pengaduan.edit', encrypt($item['IDPENGADUAN'])) }}'">
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
                                                        {{ \Carbon\Carbon::parse($item['TANGGAL_KEJADIAN'] ?? '-')->translatedFormat('d F Y') }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold">Nama Terlapor:</span>
                                                        {{ $item['NAMA_TERLAPOR'] ?? '-' }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold">Tempat Kejadian:</span>
                                                        {{ $item['TMP_KEJADIAN'] ?? '-' }}
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold">Detail Kejadian:</span>
                                                        <div class="border p-2 mt-1 rounded bg-gray-50">
                                                            {!! nl2br(e($item['DETAIL'] ?? '-')) !!}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <span class="font-semibold">Keterangan:</span>
                                                        <div class="border p-2 mt-1 rounded bg-gray-50">
                                                            {!! nl2br(e($item['KETERANGAN'] ?? '-')) !!}
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
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    @push('styles')
        <style>
            .sort-icon {
                font-size: 0.75rem;
                margin-left: 0.25rem;
                color: #666;
            }

            .sort-desc::after {
                content: " ▼";
            }
        </style>
    @endpush
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const table = document.getElementById('pengaduanUserTable');
                const headers = table.querySelectorAll('th.sort');
                const tbody = table.querySelector('tbody');
                let currentSort = {
                    column: null,
                    order: 'asc'
                };

                // Konfirmasi hapus menggunakan SweetAlert2
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        Swal.fire({
                            title: "Apakah Anda yakin?",
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Ya, hapus!",
                            cancelButtonText: "Batal",
                            scrollbarPadding: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });

                headers.forEach(header => {
                    header.addEventListener('click', function() {
                        const column = header.dataset.sort;
                        const rows = Array.from(tbody.querySelectorAll('tr'));

                        const isAsc = currentSort.column === column && currentSort.order === 'asc';
                        currentSort = {
                            column,
                            order: isAsc ? 'desc' : 'asc'
                        };

                        headers.forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
                        header.classList.add(isAsc ? 'sort-desc' : 'sort-asc');

                        rows.sort((a, b) => {
                            const aText = a.querySelector(
                                `td:nth-child(${header.cellIndex + 1})`).innerText.trim();
                            const bText = b.querySelector(
                                `td:nth-child(${header.cellIndex + 1})`).innerText.trim();

                            return isAsc ?
                                aText.localeCompare(bText, undefined, {
                                    numeric: true
                                }) :
                                bText.localeCompare(aText, undefined, {
                                    numeric: true
                                });
                        });

                        rows.forEach(row => tbody.appendChild(row));
                    });
                });

                // Search
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', function() {
                    const searchTerm = searchInput.value.toLowerCase();
                    document.querySelectorAll('#pengaduanUserTable tbody tr').forEach(row => {
                        const match = row.textContent.toLowerCase().includes(searchTerm);
                        row.style.display = match ? '' : 'none';
                    });
                });

                // Alert fadeout
                setTimeout(() => {
                    document.querySelectorAll('.alert').forEach(alert => {
                        alert.style.transition = 'opacity 0.5s ease-out';
                        alert.style.opacity = 0;
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 3000);
            });
        </script>
    @endpush
</x-app-layout>
