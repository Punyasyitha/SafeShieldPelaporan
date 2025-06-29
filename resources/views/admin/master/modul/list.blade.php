<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST MODUL</h6>
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

            <!-- Wrapper untuk Responsivitas -->
            <div class="overflow-x-auto">
                <table id="modulTable" class="table-fixed border-gray-300 text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-2 min-w-[50px] text-left truncate cursor-pointer sort" data-sort="no">
                                No
                            </th>
                            <th class="py-3 px-2 min-w-[80px] text-left truncate cursor-pointer sort"
                                data-sort="IDMODUL">
                                ID Modul
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="NAMA_MODUL">
                                Nama Modul
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="DESKRIPSI">
                                Deskripsi
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="TAHUN_TERBIT">
                                Tahun Terbit
                            </th>
                            <th class="py-3 px-2 min-w-[00px] text-left truncate">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $index => $mod)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-2 truncate">
                                    {{ $index + 1 }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod['IDMODUL'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod['NAMA_MODUL'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod['DESKRIPSI'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod['TAHUN_TERBIT'] ?? '-' }}</td>
                                <td class="py-3 px-2 flex flex-wrap gap-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Lihat"
                                        onclick="window.location='{{ url($url . '/show/' . encrypt($mod['IDMODUL'])) }}'">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Edit"
                                        onclick="window.location='{{ url($url . '/edit/' . encrypt($mod['IDMODUL'])) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form
                                        action="{{ route('admin.master.modul.delete', encrypt($mod['IDMODUL'])) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn inline-flex items-center"
                                            title="Hapus" data-id="{{ encrypt($mod['IDMODUL']) }}">
                                            <i class="fas fa-trash mr-1"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- Akhir Wrapper Tabel -->
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
                const table = document.getElementById('modulTable');
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
                    document.querySelectorAll('#modulTable tbody tr').forEach(row => {
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
