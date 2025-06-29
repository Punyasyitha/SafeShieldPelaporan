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
                action="{{ route('admin.pengaduan.update', encrypt($pengaduan->IDPENGADUAN)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Pengaduan</label>
                    <input type="text" name="idpengaduan" value="{{ old('idpengaduan', $pengaduan->IDPENGADUAN) }}"
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
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1 mb-2 {{ $warnaStatus[$pengaduan->NAMA_STATUS] ?? 'bg-gray-200 text-gray-800' }}">
                        {{ $pengaduan->NAMA_STATUS }}
                    </div>

                    {{-- Dropdown --}}
                    <select name="statusid" required id="statusSelect"
                        class="w-full mt-1 p-2 border border-gray-200 rounded-lg">
                        @foreach ($statusList as $index => $sts)
                            <option value="{{ $sts->IDSTATUS }}" data-nama="{{ $sts->NAMA_STATUS }}"
                                {{ $sts->IDSTATUS == $pengaduan->STATUSID ? 'selected' : '' }}>
                                {{ $sts->NAMA_STATUS }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Pengadu</label>
                    <input type="text" name="nama_pengadu"
                        value="{{ old('nama_pengadu', $pengaduan->NAMA_PENGADU) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">No Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $pengaduan->NO_TELEPON) }}"
                        readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="{{ old('email', $pengaduan->EMAIL) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Terlapor</label>
                    <input type="text" name="nama_terlapor"
                        value="{{ old('nama_terlapor', $pengaduan->NAMA_TERLAPOR) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tempat Kejadian</label>
                    <input type="text" name="tmp_kejadian"
                        value="{{ old('tmp_kejadian', $pengaduan->TMP_KEJADIAN) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Kejadian</label>
                    <input type="text" name="tanggal_kejadian"
                        value="{{ old('tanggal_kejadian', $pengaduan->TANGGAL_KEJADIAN) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Detail</label>
                    <textarea name="detail" readonly rows="5"
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed resize-none">{{ old('detail', $pengaduan->DETAIL) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Bukti</label>
                    <input type="text" name="bukti" value="{{ old('bukti', $pengaduan->BUKTI) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200 resize-none">{{ old('keterangan', $pengaduan->KETERANGAN) }}</textarea>
                </div>

            </form>
        </div>
    </div>

    <script>
        const select = document.getElementById('statusSelect');
        const badge = document.getElementById('badgeStatus');

        const warnaStatus = {
            'Verifikasi': 'bg-red-200 text-red-800',
            'Panggilan': 'bg-orange-200 text-orange-800',
            'Tinjauan': 'bg-yellow-200 text-yellow-800',
            'Final': 'bg-blue-200 text-blue-800',
            'Selesai': 'bg-green-200 text-green-800',
        };

        function updateBadge() {
            const selectedOption = select.options[select.selectedIndex];
            const namaStatus = selectedOption.dataset.nama;

            badge.className = 'inline-block px-3 py-1 rounded-full text-sm font-semibold mt-1 mb-2 ' + (warnaStatus[
                namaStatus] || 'bg-gray-200 text-gray-800');
            badge.innerText = namaStatus || '-';
        }

        select.addEventListener('change', updateBadge);
        document.addEventListener('DOMContentLoaded', updateBadge); // Inisialisasi saat halaman dimuat
    </script>

</x-app-layout>
