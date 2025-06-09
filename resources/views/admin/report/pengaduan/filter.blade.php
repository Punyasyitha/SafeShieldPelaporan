<x-app-layout>
    <div class="container mx-auto py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <form method="GET" action="{{ url('admin/report/pengaduan/result') }}" id="filterForm">
                        <div>
                            <h6 class="text-lg font-bold mb-2">FILTER REKAP PENGADUAN</h6>
                            <hr class="my-4 border-gray-300">
                            <div class="space-y-6">
                                {{-- Rentang Tanggal --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rentang Tanggal
                                        Pengaduan</label>
                                    <div class="grid grid-cols-2 gap-2 mt-1">
                                        <input type="date" name="from_date" value="{{ request('from_date') }}"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <input type="date" name="to_date" value="{{ request('to_date') }}"
                                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                {{-- Status Pengaduan --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Pengaduan</label>
                                    <select name="statusid"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">-- Semua Status --</option>
                                        @php
                                            $statuses = DB::table('mst_sts_pengaduan')->orderBy('idstatus')->get();
                                        @endphp
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->idstatus }}"
                                                {{ request('statusid') == $status->idstatus ? 'selected' : '' }}>
                                                {{ $status->nama_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr class="my-4 border-gray-300">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-700">Execute</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- JavaScript: validasi tanggal --}}
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            const from = document.getElementById('from_date').value;
            const to = document.getElementById('to_date').value;

            if (from && to && from > to) {
                e.preventDefault();
                alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
            }
        });
    </script>
</x-app-layout>
