<x-app-layout>
    <div class="w-full px-4 py-2">
        <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST STATUS</h6>
                <hr class="horizontal dark mt-1 mb-2">
                <div class="flex justify-between items-center mt-5">
                    <button class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-plus"></i> Tambah Status
                    </button>
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pink-100">
                </div>
            </div>

            <table id="statusTable" class="min-w-full bg-gray-500 border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left cursor-pointer" onclick="sortTable(0)">
                            No <i class="fas fa-sort"></i>
                        </th>
                        <th class="py-3 px-6 text-left cursor-pointer" onclick="sortTable(1)">
                            Nama Status <i class="fas fa-sort"></i>
                        </th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach ($list as $sts)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td>{{ $sts->idstatus }}</td>
                            <td>{{ $sts->nama_status }}</td>
                            <td class="text-center">
                                <button class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
