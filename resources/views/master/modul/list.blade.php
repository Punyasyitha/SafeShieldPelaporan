<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST MODUL</h6>
                <hr class="horizontal dark mt-1 mb-2">

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
                    </thead>
                    <tbody>
                        @foreach ($list as $mod)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $mod->idmodul }}</td>
                                <td class="py-3 px-6">{{ $mod->nama_modul }}</td>
                                <td class="py-3 px-6">{{ $mod->deskripsi }}</td>
                                <td class="py-3 px-6">{{ $mod->tahun_terbit }}</td>
                                <td class="py-3 px-6 flex flex-wrap gap-2">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded"
                                        onclick="window.location='{{ url($url . '/show/' . encrypt($mod->idmodul)) }}'">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>

                                    <button class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded"
                                        onclick="window.location='{{ url($url . '/edit/' . encrypt($mod->idmodul)) }}'">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('master.status.delete', encrypt($mod->idmodul)) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
