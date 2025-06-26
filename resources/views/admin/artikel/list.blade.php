<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">LIST ARTIKEL</h6>
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
                <table id="artikelTable" class="table-fixed border-gray-300 text-sm w-full">
                    <thead>
                        <tr class="bg-gray-100 text-sm leading-normal">
                            <th class="py-3 px-2 min-w-[50px] text-left truncate cursor-pointer sort" data-sort="no">
                                No
                            </th>
                            <th class="py-3 px-2 min-w-[50px] text-left truncate cursor-pointer sort"
                                data-sort="idartikel">
                                ID Artikel
                            </th>
                            <th class="py-3 px-2 min-w-[150px] text-left truncate cursor-pointer sort"
                                data-sort="nama_penulis">
                                Nama Penulis
                            </th>
                            <th class="py-3 px-2 min-w-[180px] text-left truncate cursor-pointer sort"
                                data-sort="judul_artikel">
                                Judul Artikel
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="isi_artikel">
                                Isi Artikel
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="tanggal_rilis">
                                Tanggal Rilis
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="gambar">
                                Gambar
                            </th>
                            <th class="py-3 px-2 min-w-[200px] text-left truncate cursor-pointer sort"
                                data-sort="status">
                                Status
                            </th>
                            <th class="py-3 px-2 min-w-[00px] text-left truncate">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $index => $art)
                            <tr class="border-b border-gray-300">
                                <td class="py-3 px-6 truncate">{{ $index + 1 }}</td>
                                <td class="py-3 px-6 truncate">{{ $art['IDARTIKEL'] ?? '-' }}</td>
                                {{-- Menampilkan Nama Penulis atau ID-nya jika nama tidak ada --}}
                                <td class="py-3 px-2 truncate">
                                    {{ $art['PENULISID'] ?? '-' }}
                                </td>
                                <td class="py-3 px-2 truncate">{{ $art['JUDUL_ARTIKEL'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">
                                    {{ Str::limit(strip_tags($art['ISI_ARTIKEL'] ?? '-'), 100, '...') }}
                                </td>
                                <td class="py-3 px-2 truncate">{{ $art['TANGGAL_RILIS'] ?? '-' }}</td>
                                <td class="py-3 px-2 truncate">
                                    @if ($art['GAMBAR'] ?? '-')
                                        <img src="{{ Storage::url($art['GAMBAR'] ?? '-') }}" alt="Gambar Artikel"
                                            width="100">
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="py-3 px-2 truncate">
                                    <span
                                        class="px-2 py-1 rounded-lg text-white
                                            {{ ($art['STATUS'] ?? '-') == 'draft' ? 'bg-red-500' : (($art['STATUS'] ?? '-') == 'published' ? 'bg-green-500' : 'bg-orange-500') }}">
                                        {{ ucfirst($art['STATUS'] ?? '-') }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 flex flex-wrap gap-2">
                                    {{-- Tombol Lihat --}}
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Lihat"
                                        onclick="window.location='{{ route('admin.artikel.show', encrypt($art['IDARTIKEL'])) }}'">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        title="Edit"
                                        onclick="window.location='{{ route('admin.artikel.edit', encrypt($art['IDARTIKEL'])) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.artikel.delete', encrypt($art['IDARTIKEL'])) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn inline-flex items-center gap-2"
                                            title="Hapus" data-id="{{ encrypt($art['IDARTIKEL']) }}">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush
    <style>
        div.dataTables_filter {
            display: none;
        }
    </style>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @endpush

    @push('scripts')
        <script>
            // Searching
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const tableRows = document.querySelectorAll('#artikelTable tbody tr');

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

                // Auto-hide alert setelah 3 detik
                setTimeout(() => {
                    document.querySelectorAll('.alert').forEach(alert => {
                        alert.style.transition = "opacity 0.5s ease-out";
                        alert.style.opacity = "0";
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 3000);
            });
        </script>
    @endpush
</x-app-layout>
