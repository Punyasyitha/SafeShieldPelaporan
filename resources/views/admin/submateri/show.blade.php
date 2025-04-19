<x-app-layout>
    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">VIEW SUB MATERI</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.submateri.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="button"
                        onclick="window.location='{{ route('admin.submateri.edit', encrypt($submateri->idsubmateri)) }}'"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-pen-to-square me-1"></i><span class="font-weight-bold">Edit</span>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID Sub Materi</label>
                <p class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg">{{ $submateri->idsubmateri }}
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $submateri->judul_materi }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Sub Materi</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $submateri->judul_submateri }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Isi Materi</label>
                <p class="w-full mt-1 p-2 border border-gray-300 rounded-lg">{{ $submateri->isi }}</p>
            </div>

        </div>
    </div>
</x-app-layout>
