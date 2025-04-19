<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
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

            {{-- Tombol Tambah & Pencarian --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
                <input type="text" id="searchInput" placeholder="Cari pengaduan..."
                    class="border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-pink-200 w-full md:w-1/3">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-fixed w-full text-sm text-left border-gray-200" id="pengaduanTable">
                <thead class="bg-gray-100">
                    <tr">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">ID Pengaduan</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Nama Pengadu</th>
                        <th class="py-3 px-4">No Telepon</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Nama Terlapor</th>
                        <th class="py-3 px-4">Tempat Kejadian</th>
                        <th class="py-3 px-4">Tanggal Kejadian</th>
                        <th class="py-3 px-4">Detail Kejadian</th>
                        <th class="py-3 px-4">Bukti</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $pgd)
                        <tr class="border-t border-gray-200">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $pgd->idpengaduan }}</td>

                            <td class="py-3 px-4">
                                <span
                                    class="inline-block px-3 py-1 rounded-full font-semibold break-words {{ $warnaStatus[$pgd->nama_status] ?? 'bg-gray-200 text-gray-800' }}">
                                    {{ $pgd->nama_status }}
                                </span>
                            </td>

                            <td class="py-3 px-4" title="{{ $pgd->nama_pengadu }}">
                                {{ $pgd->nama_pengadu }}
                            </td>

                            <td class="py-3 px-4" title="{{ $pgd->no_telepon }}">
                                {{ Str::limit(strip_tags($pgd->no_telepon), 8, '...') }}
                            </td>

                            <td class="py-3 px-4" title="{{ $pgd->email }}">
                                {{ Str::limit(strip_tags($pgd->email), 8, '...') }}
                            </td>

                            <td class="py-3 px-4">{{ $pgd->nama_terlapor }}</td>
                            <td class="py-3 px-4">{{ $pgd->tmp_kejadian }}</td>
                            <td class="py-3 px-4">{{ $pgd->tanggal_kejadian }}</td>

                            <td class="py-3 px-4" title="{{ strip_tags($pgd->detail) }}">
                                {{ Str::limit(strip_tags($pgd->detail), 50, '...') }}
                            </td>

                            <td class="py-3 px-4">
                                @if ($pgd->bukti)
                                    <a href="{{ asset('storage/' . $pgd->bukti) }}" target="_blank"
                                        class="text-blue-600 underline mr-2">Lihat</a>
                                    <a href="{{ asset('storage/' . $pgd->bukti) }}" download
                                        class="text-green-600 underline">Download</a>
                                @else
                                    <span class="text-gray-400">Tidak ada</span>
                                @endif
                            </td>

                            <td class="py-3 px-4" title="{{ $pgd->keterangan }}">
                                {{ Str::limit(strip_tags($pgd->keterangan), 30, '...') }}
                            </td>

                            <td class="py-3 px-4">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        onclick="window.location='{{ route('admin.pengaduan.show', encrypt($pgd->idpengaduan)) }}'">
                                        Lihat
                                    </button>

                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-white inline-flex py-1 px-3 rounded items-center gap-2"
                                        onclick="window.location='{{ route('admin.pengaduan.edit', encrypt($pgd->idpengaduan)) }}'">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.pengaduan.delete', encrypt($pgd->idpengaduan)) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded delete-btn inline-flex items-center gap-2"
                                            data-id="{{ encrypt($pgd->idpengaduan) }}">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#pengaduanTable').DataTable({
                    searching: false, // matikan fitur pencarian
                    language: {
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        },
                        zeroRecords: "Tidak ada data yang cocok",
                        infoEmpty: "Menampilkan 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)"
                    }
                });
            });

            // Fitur Pencarian
            document.getElementById('searchInput').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#pengaduanUserTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
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
        </script>
    @endpush
</x-app-layout>
