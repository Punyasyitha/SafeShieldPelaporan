<x-app-layout>
    <div class="w-full px-4 py-2">
        <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST STATUS</h6>
                <hr class="horizontal dark mt-1 mb-2">
                <div class="flex justify-between items-center mt-5">
                    {{-- @if ($authorize->add == '1')
                        <button class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg"
                            onclick="window.location='{{ URL::to($url . '/add') }}'">
                            <i class="fas fa-plus"></i><span class="font-weight-bold ml-1">Tambah</span>
                        </button>
                    @endif --}}
                    <input type="text" id="searchInput" placeholder="Search..."
                        class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pink-100">
                </div>
            </div>
            <table id="statusTable" class="min-w-full border-gray-300  text-sm">
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
                                <span class="pl-1">ID Status</span>
                                <i class="fas fa-sort ml-2"></i>
                            </div>
                        </th>
                        <th class="py-3 px-6 text-left">
                            <div class="flex justify-between items-center w-full">
                                <span class="pl-1">Nama Status</span>
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
