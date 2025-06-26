<x-app-layout>
    <form id="iniForm" action="{{ route('admin.master.status.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full bg-white shadow-lg rounded-lg mt-6 p-6">
            <div class="overflow-x-auto">
                <div class="flex flex-col mb-4">
                    <h6 class="text-lg font-bold mb-2">INSERT STATUS</h6>
                    <hr class="horizontal dark mt-1 mb-2">

                    <!-- Tombol Kembali dan Simpan di kiri -->
                    <div class="flex justify-start items-center gap-2 mt-5">
                        <button type="button" onclick="window.location='{{ route('admin.master.status.list') }}'"
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

                <!-- Form input ID Status (read-only) dan Nama Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">ID Status</label>
                    <input type="text" name="idstatus" readonly
                        class="w-full mt-1 p-2 border border-gray-300 bg-gray-100 rounded-lg focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Status</label>
                    <input type="text" name="nama_status" required
                        class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-200">
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
