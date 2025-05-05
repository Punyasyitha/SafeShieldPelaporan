<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">EDIT PENGADUAN</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.pengaduan.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="submit" form="editPengaduanform"
                        class="bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-save me-1"></i><span class="font-weight-bold">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Form Edit Pengaduan -->
            <form id="editPengaduanform"
                action="{{ route('admin.pengaduan.update', encrypt($pengaduan->idpengaduan)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Pengaduan</label>
                    <input type="text" name="idpengaduan" value="{{ old('idpengaduan', $pengaduan->idpengaduan) }}"
                        readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none cursor-not-allowed">
                </div>

                @php
                    $warnaStatus = [
                        'Verifikasi' => 'bg-red-200 text-red-800',
                        'Panggilan' => 'bg-orange-200 text-orange-800',
                        'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                        'Final' => 'bg-blue-200 text-blue-800',
                        'Selesai' => 'bg-green-200 text-green-800',
                    ];
                @endphp

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Status</label>

                    {{-- Tampilkan badge status berwarna --}}
                    <div id="badgeStatus"
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1 mb-2 {{ $warnaStatus[$pengaduan->status->nama_status] ?? 'bg-gray-200 text-gray-800' }}">
                        {{ $pengaduan->status->nama_status }}
                    </div>

                    {{-- Dropdown --}}
                    <select name="statusid" required id="statusSelect"
                        class="w-full mt-1 p-2 border border-gray-200 rounded-lg">
                        @foreach ($status as $sts)
                            <option value="{{ $sts->idstatus }}" data-nama="{{ $sts->nama_status }}"
                                {{ $sts->idstatus == $pengaduan->statusid ? 'selected' : '' }}>
                                {{ $sts->nama_status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Pengadu</label>
                    <input type="text" name="nama_pengadu"
                        value="{{ old('nama_pengadu', $pengaduan->nama_pengadu) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">No Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaduan->no_telepon) }}"
                        readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="{{ old('email', $pengaduan->email) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Terlapor</label>
                    <input type="text" name="nama_terlapor"
                        value="{{ old('nama_terlapor', $pengaduan->nama_terlapor) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tempat Kejadian</label>
                    <input type="text" name="tmp_kejadian"
                        value="{{ old('tmp_kejadian', $pengaduan->tmp_kejadian) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Kejadian</label>
                    <input type="text" name="tanggal_kejadian"
                        value="{{ old('tanggal_kejadian', $pengaduan->tanggal_kejadian) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Detail</label>
                    <textarea name="detail" readonly rows="5"
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed resize-none">{{ old('detail', $pengaduan->detail) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Bukti</label>
                    <input type="text" name="bukti" value="{{ old('bukti', $pengaduan->bukti) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200 resize-none">{{ old('keterangan', $pengaduan->keterangan) }}</textarea>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('statusSelect');
            const badgeStatus = document.getElementById('badgeStatus');

            const warnaStatus = {
                'Verifikasi' => 'bg-red-200 text-red-800',
                'Panggilan' => 'bg-orange-200 text-orange-800',
                'Tinjauan' => 'bg-yellow-200 text-yellow-800',
                'Final' => 'bg-blue-200 text-blue-800',
                'Selesai' => 'bg-green-200 text-green-800',
            };

            function updateBadge() {
                const selectedOption = statusSelect.options[statusSelect.selectedIndex];
                const statusName = selectedOption.dataset.nama;
                badgeStatus.textContent = statusName;

                // Reset semua class lalu tambahkan yang sesuai
                badgeStatus.className =
                    `inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1 mb-2 ${warnaStatus[statusName] || 'bg-gray-200 text-gray-800'}`;
            }

            statusSelect.addEventListener('change', updateBadge);
        });
    </script>

</x-app-layout>
