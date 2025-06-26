<x-app-layout>
    <form id="iniForm" action="{{ route('admin.submateri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
            <div class="overflow-x-auto">
                <div class="flex flex-col mb-4">
                    <h6 class="text-lg font-bold mb-2">INSERT SUB MATERI</h6>
                    <hr class="horizontal dark mt-1 mb-2">

                    <div class="flex justify-start items-center gap-2 mt-5">
                        <button type="button" onclick="window.location='{{ route('admin.submateri.list') }}'"
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
                    <label class="block text-sm font-medium text-gray-700">ID Sub Materi</label>
                    <input type="text" name="idsubmateri" value="{{ old('idsubmateri', $newId ?? '') }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Materi</label>
                    <select name="materiid" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                        @foreach ($materi as $mtr)
                            <option value="{{ $mtr['IDMATERI'] }}">{{ $mtr['JUDUL_MATERI'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Judul Sub Materi</label>
                    <input type="text" name="judul_submateri" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Isi Materi</label>
                    <textarea name="isi" required rows="4"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200 resize-none"></textarea>
                </div>
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
    </script>
</x-app-layout>
