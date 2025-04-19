<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">VIEW ARTIKEL</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.artikel.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="button"
                        onclick="window.location='{{ route('admin.artikel.edit', encrypt($artikel->idartikel)) }}'"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-pen-to-square me-1"></i><span class="font-weight-bold">Edit</span>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $artikel->idartikel }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $artikel->nama_penulis }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $artikel->judul_artikel }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                    {{ Str::limit($artikel->isi_artikel, 200, '...') }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $artikel->tanggal_rilis }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gambar Artikel</label>
                <div class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-center">
                    @if ($artikel->gambar)
                        <div>
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Artikel"
                                style="max-width: 200px;">
                        </div>
                    @else
                        <p><strong>Gambar:</strong> Tidak ada gambar</p>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                    <span
                        class="px-2 py-1 rounded-lg text-white
                            {{ $artikel->status == 'draft' ? 'bg-red-500' : ($artikel->status == 'published' ? 'bg-green-500' : 'bg-orange-500') }}">
                        {{ ucfirst($artikel->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
