<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">EDIT MATERI</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.materi.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="submit" form="editMateriform"
                        class="bg-purple-300 hover:bg-purple-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-save me-1"></i><span class="font-weight-bold">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Form Edit Modul -->
            <form id="editMateriform" action="{{ route('admin.materi.update', encrypt($materi->idmateri)) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Materi</label>
                    <input type="text" name="idmateri" value="{{ old('idmateri', $materi->idmateri) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Modul</label>
                    <select name="modulid" id="modulSelect" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                        <option value="">-- Pilih Modul --</option>
                        @foreach ($modul as $mdl)
                            <option value="{{ $mdl->idmodul }}" data-deskripsi="{{ $mdl->deskripsi }}"
                                {{ $materi->modulid == $mdl->idmodul ? 'selected' : '' }}>
                                {{ $mdl->nama_modul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsiText" class="w-full mt-1 p-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                        {{ $modul->firstWhere('idmodul', $materi->modulid)?->deskripsi }}
                    </textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <select name="kategoriid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                        @foreach ($kategori as $ktg)
                            <option value="{{ $ktg->idkategori }}"
                                {{ $ktg->idkategori == $materi->kategoriid ? 'selected' : '' }}>
                                {{ $ktg->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                    <input type="text" name="judul_materi" value="{{ old('judul_materi', $materi->judul_materi) }}"
                        required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Sumber</label>
                    <input type="text" name="sumber" id="sumber"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 text-blue-600"
                        value="{{ old('sumber', $materi->sumber) }}" placeholder="Masukkan URL sumber">
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectModul = document.getElementById('modulSelect');
            const deskripsiText = document.getElementById('deskripsiText');

            // Update textarea saat pertama kali load (untuk form edit)
            const selectedOption = selectModul.options[selectModul.selectedIndex];
            if (selectedOption && selectedOption.dataset.deskripsi) {
                deskripsiText.value = selectedOption.dataset.deskripsi;
            }

            // Update textarea saat user memilih modul lain
            selectModul.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                deskripsiText.value = selected.dataset.deskripsi || '';
            });
        });
    </script>

</x-app-layout>
