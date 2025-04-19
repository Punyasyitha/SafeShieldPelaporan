<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">EDIT ARTIKEL</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.artikel.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="submit" form="editArtikelform"
                        class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-save me-1"></i><span class="font-weight-bold">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Form Edit Artikel -->
            <form id="editArtikelform" action="{{ route('admin.artikel.update', encrypt($artikel->idartikel)) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Artikel</label>
                    <input type="text" name="idartikel" value="{{ old('idartikel', $artikel->idartikel) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                    <select name="penulisid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                        @foreach ($penulis as $pns)
                            <option value="{{ $pns->idpenulis }}"
                                {{ $pns->idpenulis == $artikel->penulisid ? 'selected' : '' }}>
                                {{ $pns->nama_penulis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                    <input type="text" name="judul_artikel"
                        value="{{ old('judul_artikel', $artikel->judul_artikel) }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                    <textarea name="isi_artikel" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200 resize-none">{{ old('isi_artikel', $artikel->isi_artikel) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <input type="date" name="tanggal_rilis"
                        value="{{ old('tanggal_rilis', $artikel->tanggal_rilis) }}" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                </div>

                <!-- Upload Gambar Artikel -->
                <div class="mb-4">
                    <label for="gambar" class="block font-medium">Gambar</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="w-full border p-2 rounded">

                    @if ($artikel->gambar)
                        <p class="mt-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Artikel"
                            class="w-32 h-32 object-cover mt-2">

                        <!-- Checkbox untuk menghapus gambar -->
                        <div class="mt-2">
                            <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1">
                            <label for="hapus_gambar">Hapus gambar saat ini</label>
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="statusSelect" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2"
                        onchange="updateBorder()">
                        <option value="draft" {{ $artikel->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $artikel->status == 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="archived" {{ $artikel->status == 'archived' ? 'selected' : '' }}>Archived
                        </option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateBorder() {
            const select = document.getElementById('statusSelect');
            select.className = "w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 " +
                (select.value === 'draft' ? 'focus:ring-red-400' :
                    select.value === 'published' ? 'focus:ring-green-400' :
                    'focus:ring-orange-400');
        }
    </script>
</x-app-layout>
