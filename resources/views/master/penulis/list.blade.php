<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST PENULIS</h6>
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
                <table id="statusTable" class="min-w-full border-gray-300 text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-6 text-left w-10">No</th>
                            <th class="py-3 px-6 text-left w-40">ID Penulis</th>
                            <th class="py-3 px-6 text-left w-64">Nama Penulis</th>
                            <th class="py-3 px-6 text-left w-56">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $pns)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $pns->idpenulis }}</td>
                                <td class="py-3 px-6">{{ $pns->nama_penulis }}</td>
                                <td class="py-3 px-6 flex flex-wrap gap-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded"
                                        onclick="window.location='{{ url($url . '/show/' . encrypt($pns->idpenulis)) }}'">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>

                                    <button class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded"
                                        onclick="window.location='{{ url($url . '/edit/' . encrypt($pns->idpenulis)) }}'">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('master.penulis.delete', encrypt($pns->idpenulis)) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn"
                                            data-id="{{ encrypt($pns->idpenulis) }}">
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

    <script>
        // Fungsi untuk search
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#statusTable tbody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });

        // Konfirmasi hapus
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                    scrollbarPadding: false // Mencegah perubahan margin akibat scrollbar
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
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
            const table = document.getElementById('statusTable');
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
