<x-app-layout>

    <div class="w-full bg-white shadow-lg rounded-lg p-6">
        <div class="overflow-x-auto">
            <div class="flex flex-col mb-4">
                <h6 class="text-lg font-bold mb-2">EDIT PENULIS</h6>
                <hr class="horizontal dark mt-1 mb-2">

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-start items-center gap-2 mt-5">
                    <button type="button" onclick="window.location='{{ route('admin.master.penulis.list') }}'"
                        class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-circle-left me-1"></i><span class="font-weight-bold ml-1">Kembali</span>
                    </button>

                    <button type="submit" form="editPenulisForm"
                        class="bg-pink-300 hover:bg-pink-400 text-white font-semibold py-2 px-4 rounded-lg">
                        <i class="fas fa-save me-1"></i><span class="font-weight-bold">Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Form Edit Penulis -->
            <form id="editPenulisForm" action="{{ route('admin.master.penulis.update', encrypt($penulis->idpenulis)) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Penulis</label>
                    <input type="text" name="idpenulis" value="{{ $penulis->idpenulis }}" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Penulis</label>
                    <input type="text" name="nama_penulis" value="{{ $penulis->nama_penulis }}"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-pink-200"
                        required>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
