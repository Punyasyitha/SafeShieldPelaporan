<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">VIEW PENGADUAN</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.pengaduan.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="button"
                        onclick="window.location='{{ route('admin.pengaduan.edit', encrypt($pengaduan->IDPENGADUAN)) }}'"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-pen-to-square me-1"></i><span class="font-weight-bold">Edit</span>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Pengaduan</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->IDPENGADUAN }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Status</label>
                @php
                    $status = $pengaduan->NAMA_STATUS ?? '-';
                    $class = $warnaStatus[$status] ?? 'bg-gray-200 text-gray-800';
                @endphp
                <p class="w-fit mt-1 px-3 py-1 rounded-full text-sm font-semibold {{ $class }}">
                    {{ $status }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Pengadu</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->NAMA_PENGADU }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">No Telepon</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->NO_TELEPON }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->EMAIL }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Terlapor</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->NAMA_TERLAPOR }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tempat Kejadian</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $pengaduan->TMP_KEJADIAN }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Kejadian</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">
                    {{ $pengaduan->TANGGAL_KEJADIAN }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Detail</label>
                <textarea name="detail" readonly rows="5"
                    class="w-full mt-1 p-2 border border-gray-200 bg-gray-100 rounded-lg cursor-not-allowed resize-none">{{ $pengaduan->DETAIL }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Bukti</label>
                <div class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">
                    @if ($pengaduan->BUKTI)
                        <a href="{{ asset('storage/' . $pengaduan->BUKTI) }}" download class="text-blue-600 underline">
                            {{ basename($pengaduan->BUKTI) }}
                        </a>
                    @else
                        <span class="text-gray-500">Tidak ada bukti</span>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="4" readonly
                    class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg resize-none cursor-not-allowed"
                    placeholder="Belum diisi">{{ old('keterangan', $pengaduan->KETERANGAN) }}</textarea>
            </div>


        </div>
    </div>
</x-app-layout>
