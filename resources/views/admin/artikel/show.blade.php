<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
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
                        onclick="window.location='{{ route('admin.artikel.edit', encrypt($art->IDARTIKEL)) }}'"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-pen-to-square me-1"></i><span class="font-weight-bold">Edit</span>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $art->IDARTIKEL }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg ">{{ $art->PENULISID }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $art->JUDUL_ARTIKEL }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">
                    {{ Str::limit($art->ISI_ARTIKEL ?? '-', 200, '...') }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                <input type="date" name="tanggal_rilis"
                    value="{{ $art->TANGGAL_RILIS = \Carbon\Carbon::createFromFormat('d-M-y', $art->TANGGAL_RILIS)->format('Y-m-d') }}"
                    readonly required
                    class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Gambar Artikel</label>
                <div class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg text-center">
                    @if ($art->GAMBAR ?? '-')
                        <div>
                            <img src="{{ asset('storage/' . $art->GAMBAR ?? '-') }}" alt="Gambar Artikel"
                                style="max-width: 200px;">
                        </div>
                    @else
                        <p><strong>Gambar:</strong> Tidak ada gambar</p>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">
                    <span
                        class="px-2 py-1 rounded-lg text-white
                            {{ ($art->STATUS ?? '-') == 'draft' ? 'bg-red-500' : (($art->STATUS ?? '-') == 'published' ? 'bg-green-500' : 'bg-orange-500') }}">
                        {{ ucfirst($art->STATUS ?? '-') }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
