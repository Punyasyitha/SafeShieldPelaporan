<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6 mt-6">
        <div class="flex flex-col mb-4">
            <h6 class="text-lg font-bold mb-2">PENGADUAN</h6>
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

            {{-- Tombol Pencarian --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
                <input type="text" id="searchInput" placeholder="Search..."
                    class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-purple-200 w-full md:w-1/3">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-fixed w-full text-sm text-left border-gray-200" id="pengaduanTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-2 min-w-[50px] truncate">No</th>
                        <th class="py-3 px-2 min-w-[100px] truncate">ID Pengaduan</th>
                        <th class="py-3 px-2 min-w-[120px] truncate">Status</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Nama Pengadu</th>
                        <th class="py-3 px-2 min-w-[120px] truncate">No Telepon</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Email</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Nama Terlapor</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Tempat Kejadian</th>
                        <th class="py-3 px-2 min-w-[130px] truncate">Tanggal Kejadian</th>
                        <th class="py-3 px-2 min-w-[200px] truncate">Detail Kejadian</th>
                        <th class="py-3 px-2 min-w-[100px] truncate">Bukti</th>
                        <th class="py-3 px-2 min-w-[150px] truncate">Keterangan</th>
                        <th class="py-3 px-2 min-w-[130px] truncate">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $pgd)
                        <tr class="border-t border-gray-200">
                            <td class="py-3 px-2 truncate">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 truncate">{{ $pgd->idpengaduan }}</td>
                            <td class="py-3 px-2 truncate">
                                <span
                                    class="inline-block px-3 py-1 rounded-full font-semibold break-words {{ $warnaStatus[$pgd->nama_status] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ $pgd->nama_status }}
                                </span>
                            </td>
                            <td class="py-3 px-2 truncate" title="{{ $pgd->nama_pengadu }}">{{ $pgd->nama_pengadu }}
                            </td>
                            <td class="py-3 px-2 truncate" title="{{ $pgd->no_telepon }}">
                                {{ Str::limit(strip_tags($pgd->no_telepon), 8, '...') }}</td>
                            <td class="py-3 px-2 truncate" title="{{ $pgd->email }}">
                                {{ Str::limit(strip_tags($pgd->email), 8, '...') }}</td>
                            <td class="py-3 px-2 truncate">{{ $pgd->nama_terlapor }}</td>
                            <td class="py-3 px-2 truncate">{{ $pgd->tmp_kejadian }}</td>
                            <td class="py-3 px-2 truncate">{{ $pgd->tanggal_kejadian }}</td>
                            <td class="py-3 px-2 truncate" title="{{ strip_tags($pgd->detail) }}">
                                {{ Str::limit(strip_tags($pgd->detail), 50, '...') }}</td>
                            <td class="py-3 px-2 truncate">
                                @if ($pgd->bukti)
                                    <a href="{{ asset('storage/' . $pgd->bukti) }}" target="_blank"
                                        class="text-blue-600 underline mr-2">Lihat</a>
                                    <a href="{{ asset('storage/' . $pgd->bukti) }}" download
                                        class="text-green-600 underline">Download</a>
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-2 truncate" title="{{ $pgd->keterangan }}">
                                {{ Str::limit(strip_tags($pgd->keterangan), 30, '...') }}</td>
                            <td class="py-3 px-2 truncate">
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-2 rounded items-center gap-2"
                                        title="Lihat"
                                        onclick="window.location='{{ route('admin.pengaduan.show', encrypt($pgd->idpengaduan)) }}'">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-2 rounded items-center gap-2"
                                        title="Edit"
                                        onclick="window.location='{{ route('admin.pengaduan.edit', encrypt($pgd->idpengaduan)) }}'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.pengaduan.delete', encrypt($pgd->idpengaduan)) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded delete-btn inline-flex items-center gap-2"
                                            title="Hapus" data-id="{{ encrypt($pgd->idpengaduan) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $list->links() }}
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
                const tableRows = document.querySelectorAll('#pengaduanTable tbody tr');

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
