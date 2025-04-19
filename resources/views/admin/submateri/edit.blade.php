<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">EDIT SUB MATERI</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.submateri.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="submit" form="editSubMateriform"
                        class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-save me-1"></i><span class="font-weight-bold">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Form Edit Modul -->
            <form id="editSubMateriform" action="{{ route('admin.submateri.update', encrypt($submateri->idsubmateri)) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Sub Materi</label>
                    <input type="text" name="idsubmateri" value="{{ old('idsubmateri', $submateri->idsubmateri) }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                    <select name="materiid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                        @foreach ($materi as $mtr)
                            <option value="{{ $mtr->idmateri }}"
                                {{ $mtr->idmateri == $submateri->materiid ? 'selected' : '' }}>
                                {{ $mtr->judul_materi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Sub Materi</label>
                    <input type="text" name="judul_submateri" value="{{ old('judul_submateri', $submateri->judul_submateri) }}"
                        required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Isi Materi</label>
                    <textarea name="isi" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-200 resize-none">{{ old('isi', $submateri->isi) }}</textarea>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>
