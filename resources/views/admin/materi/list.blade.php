<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST MATERI</h6>
                <hr class="horizontal dark mt-1 mb-2">
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

                <!-- Tombol & Search Input (Responsif) -->
                <div class="flex flex-wrap justify-between items-center gap-2 mt-5">
                    @if ($authorize->add == '1')
                        <button
                            class="bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 px-4 rounded-lg flex items-center"
                            onclick="window.location='{{ URL::to($url . '/add') }}'">
                            <i class="fas fa-plus"></i>
                            <span class="font-weight-bold ml-1">Tambah</span>
                        </button>
                    @endif
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-purple-100 w-full md:w-auto">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="materiTable" class="table-fixed border-gray-300 text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-2 min-w-[50px] text-left truncate cursor-pointer sort" data-sort="no">
                                No
                            </th>
                            <th class="py-3 px-2 min-w-[80px] text-left truncate cursor-pointer sort"
                                data-sort="idmateri">
                                ID Materi
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="nama_modul">
                                Nama Modul
                            </th>
                            <th class="py-3 px-2 min-w-[180px] text-left truncate cursor-pointer sort"
                                data-sort="nama_kategori">
                                Nama Kategori
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="judul_materi">
                                Judul Materi
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="sumber">
                                Sumber
                            </th>
                            <th class="py-3 px-2 min-w-[00px] text-left truncate">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $index => $mtr)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-2 truncate">{{ $index + 1 }}</td>
                                <td class="py-3 px-2 truncate">{{ $mtr['IDMATERI'] ?? '-' }}</td>
                                {{-- Menampilkan Nama Mdoul atau ID-nya jika nama tidak ada --}}
                                <td class="py-3 px-2 truncate">
                                    {{ $mtr['MODULID'] ?? '-' }}
                                </td>
                                <td class="py-3 px-2 truncate">
                                    {{ $mtr['KATEGORIID'] ?? '-' }}
                                </td>
                                <td class="py-3 px-2 truncate">{{ $mtr['JUDUL_MATERI'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate"><a href="{{ $mtr['SUMBER'] ?? '-' }}"
                                        class="text-blue-600 hover:underline" target="_blank">
                                        {{ $mtr['SUMBER'] ?? '-' }}
                                    </a></td>
                                <td class="py-3 px-2 flex flex-wrap gap-2">
                                    {{-- Tombol Lihat --}}
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Lihat"
                                        onclick="window.location='{{ route('admin.materi.show', encrypt($mtr['IDMATERI'])) }}'">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Edit"
                                        onclick="window.location='{{ route('admin.materi.edit', encrypt($mtr['IDMATERI'])) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.materi.delete', encrypt($mtr['IDMATERI'])) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn inline-flex items-center gap-2"
                                            title="Hapus" data-id="{{ encrypt($mtr['IDMATERI']) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                const table = document.getElementById('materiTable');
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
                    document.querySelectorAll('#materiTable tbody tr').forEach(row => {
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
