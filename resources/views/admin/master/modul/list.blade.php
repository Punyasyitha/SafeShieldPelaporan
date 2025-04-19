<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
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
                            class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg flex items-center"
                            onclick="window.location='{{ URL::to($url . '/add') }}'">
                            <i class="fas fa-plus"></i>
                            <span class="font-weight-bold ml-1">Tambah</span>
                        </button>
                    @endif
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pink-100 w-full md:w-auto">
                </div>
            </div>

            <!-- Wrapper untuk Responsivitas -->
            <div class="overflow-x-auto">
                <table id="modulTable" class="table-fixed border-gray-300 text-sm w-full">
                    {{-- <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span class="pl-1">No</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span class="pl-1">ID Modul</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span class="pl-1">Nama Modul</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span class="pl-1">Deskripsi</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span class="pl-1">Tahun Terbit</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                            <th class="py-3 px-6 text-left">
                                <div class="flex justify-between items-center w-full">
                                    <span>Aksi</span>
                                    <i class="fas fa-sort ml-2"></i>
                                </div>
                            </th>
                        </tr>
                    </thead> --}}
                    <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-2 min-w-[50px] text-left truncate cursor-pointer sort" data-sort="no">
                                No <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-3 px-2 min-w-[80px] text-left truncate cursor-pointer sort"
                                data-sort="idmodul">
                                ID Modul <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="nama_modul">
                                Nama Modul <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="deskripsi">
                                Deskripsi <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="tahun_terbit">
                                Tahun Terbit <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-3 px-2 min-w-[00px] text-left truncate">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $mod)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-2 truncate">{{ $loop->iteration }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod->idmodul }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod->nama_modul }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod->deskripsi }}</td>
                                <td class="py-3 px-2 truncate">{{ $mod->tahun_terbit }}</td>
                                <td class="py-3 px-2 flex flex-wrap gap-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        onclick="window.location='{{ url($url . '/show/' . encrypt($mod->idmodul)) }}'">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>

                                    <button class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        onclick="window.location='{{ url($url . '/edit/' . encrypt($mod->idmodul)) }}'">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('admin.master.modul.delete', encrypt($mod->idmodul)) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn inline-flex items-center gap-2"
                                            data-id="{{ encrypt($mod->idmodul) }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- Akhir Wrapper Tabel -->

            <!-- Pagination -->
            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>


    <!-- Pastikan SweetAlert2 sudah dimuat -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk search
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#modulTable tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Konfirmasi hapus menggunakan SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
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
        });

        // Auto-hide alert setelah 3 detik
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s ease-out";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah efek fade-out selesai
            });
        }, 3000);

        // Fungsi untuk sort
        function sortTable(columnIndex) {
            const table = document.getElementById('modulTable');
            const rows = Array.from(table.rows).slice(1);
            let isAsc = table.getAttribute('data-sort-asc') === 'true';
            rows.sort((a, b) => {
                const aText = a.cells[columnIndex].innerText.trim();
                const bText = b.cells[columnIndex].innerText.trim();
                return isAsc ? aText.localeCompare(bText) : bText.localeCompare(aText);
            });
            rows.forEach(row => table.tBodies[0].appendChild(row));
            table.setAttribute('data-sort-asc', !isAsc);
        }
    </script>
</x-app-layout>
