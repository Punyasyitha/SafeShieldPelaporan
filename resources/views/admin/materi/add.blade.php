<x-app-layout>
    <form id="iniForm" action="{{ route('admin.materi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full bg-white shadow-lg rounded-lg p-6">
            <div class="overflow-x-auto">
                <div class="flex flex-col mb-4">
                    <h6 class="text-lg font-bold mb-2">INSERT MATERI</h6>
                    <hr class="horizontal dark mt-1 mb-2">

                    <div class="flex justify-start items-center gap-2 mt-5">
                        <button type="button" onclick="window.location='{{ route('admin.materi.list') }}'"
                            class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                            <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                        </button>

                        @if ($authorize->add == '1')
                            <button id="submitForm"
                                class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                                <i class="fas fa-floppy-disk me-1"></i>
                                <span class="font-weight-bold">Simpan</span>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Materi</label>
                    <input type="text" name="idmateri" value="{{ old('idmateri', $newId ?? '') }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Modul</label>
                    <select name="modulid" id="modulSelect" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                        <option value="">Pilih Modul</option>
                        @foreach ($modul as $mdl)
                            <option value="{{ $mdl->idmodul }}" data-deskripsi="{{ $mdl->deskripsi }}">
                                {{ $mdl->nama_modul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsiText" class="w-full mt-1 p-2 border border-gray-300 rounded-lg bg-gray-100" readonly></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <select name="kategoriid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $ktg)
                            <option value="{{ $ktg->idkategori }}">{{ $ktg->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                    <input type="text" name="judul_materi" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Sumber</label>
                    <input type="url" name="sumber" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200"
                        placeholder="https://example.com">
                </div>
                @error('sumber')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </form>

    <script>
        function updateBorder() {
            const select = document.getElementById('statusSelect');
            select.className = "w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 " +
                (select.value === 'draft' ? 'focus:ring-red-400' :
                    select.value === 'published' ? 'focus:ring-green-400' :
                    'focus:ring-orange-400');
        }

        document.querySelector('input[name="sumber"]').addEventListener('input', function() {
            const pattern = /^(https?:\/\/)[^\s$.?#].[^\s]*$/;
            if (!pattern.test(this.value)) {
                this.classList.add("border-red-500");
            } else {
                this.classList.remove("border-red-500");
            }
        });

        document.getElementById('modulSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const deskripsi = selectedOption.getAttribute('data-deskripsi') || '';
            document.getElementById('deskripsiText').value = deskripsi;
        });
    </script>
</x-app-layout>
