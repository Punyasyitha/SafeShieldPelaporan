<x-app-layout>
    <form id="iniForm" action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
            <div class="overflow-x-auto">
                <div class="flex flex-col mb-4">
                    <h6 class="text-lg font-bold mb-2">INSERT ARTIKEL</h6>
                    <hr class="horizontal dark mt-1 mb-2">

                    <div class="flex justify-start items-center gap-2 mt-5">
                        <button type="button" onclick="window.location='{{ route('admin.artikel.list') }}'"
                            class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                            <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                        </button>

                        @if ($authorize->add == '1')
                            <button id="submitForm"
                                class="bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 px-4 rounded-lg">
                                <i class="fas fa-floppy-disk me-1"></i>
                                <span class="font-weight-bold">Simpan</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Artikel</label>
                    <input type="text" name="idartikel" value="{{ old('idartikel', $newId ?? '') }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                    <select name="penulisid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                        @foreach ($penulis as $pns)
                            <option value="{{ $pns['IDPENULIS'] }}">{{ $pns['NAMA_PENULIS'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Artikel</label>
                    <input type="text" name="judul_artikel" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Isi Artikel</label>
                    <textarea name="isi_artikel" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200 resize-none"></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <input type="date" name="tanggal_rilis" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Gambar Artikel</label>
                    <input type="file" name="gambar" accept="image/*" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                    <small class="text-gray-500">Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal ukuran:
                        100MB</small>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="statusSelect" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2"
                        onchange="updateBorder()">
                        <option value="draft" selected>Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById("submitForm").addEventListener("click", function(e) {
            const status = document.getElementById("statusSelect").value;
        });
    </script>

</x-app-layout>
