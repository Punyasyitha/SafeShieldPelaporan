<x-app-layout>
    <div class="container mx-auto py-4">
        <div class="flex flex-col mb-6 bg-white shadow-lg rounded-lg mt-6 p-3">
            <h6 class="text-lg font-bold mb-2">RESULT REKAP PENGADUAN</h6>
            <hr class="horizontal dark mt-1 mb-2">

            <!-- Tombol Navigasi -->
            <div class="flex flex-wrap justify-between items-center mt-2 gap-2">
                <button type="button" onclick="window.location='{{ route('admin.report.pengaduan.filter') }}'"
                    class="bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded-lg">
                    <i class="fas fa-circle-left me-1"></i><span class="ml-1">Kembali</span>
                </button>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white shadow rounded-lg p-4 overflow-auto">
            <table class="table-fixed w-full text-sm text-left" id="resultTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-3">No</th>
                        <th class="py-2 px-3">Tanggal</th>
                        <th class="py-2 px-3">Nama Terlapor</th>
                        <th class="py-2 px-3">Tempat Kejadian</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $item)
                        <tr class="border-t">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->format('d-m-Y') }}
                            </td>
                            <td class="py-2 px-3">{{ $item->nama_terlapor }}</td>
                            <td class="py-2 px-3">{{ $item->tmp_kejadian }}</td>
                            <td class="py-2 px-3">
                                @php
                                    $class = $warnaStatus[$item->nama_status ?? '-'] ?? 'bg-gray-200 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $class }}">
                                    {{ $item->nama_status ?? '-' }}
                                </span>
                            </td>
                            <td class="py-2 px-3">{{ Str::limit(strip_tags($item->keterangan), 60) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <style>
            .btn-excel {
                background-color: #65B741 !important;
                /* hijau */
                color: white !important;
            }

            .btn-excel:hover {
                background-color: #88D66C !important;
            }

            .btn-pdf {
                background-color: #FF1700 !important;
                /* merah */
                color: white !important;
            }

            .btn-pdf:hover {
                background-color: #EC524B !important;
            }

            .btn-print {
                background-color: #4D96FF !important;
                /* biru */
                color: white !important;
            }

            .btn-print:hover {
                background-color: #7286D3 !important;
            }

            .dataTables_wrapper .dt-buttons button i {
                margin-right: 6px;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#resultTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel me-1"></i><span>Excel</span>',
                            className: 'btn-excel',
                            title: 'Rekap Pengaduan',
                            exportOptions: {
                                columns: ':visible',
                            },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('col', sheet).each(function() {
                                    $(this).attr('width', 20);
                                    $(this).attr('customWidth', 1);
                                });
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fas fa-file-pdf me-1"></i><span>PDF</span>',
                            className: 'btn-pdf',
                            title: 'Rekap Pengaduan',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            customize: function(doc) {
                                doc.pageMargins = [20, 40, 20, 40];
                                doc.defaultStyle.fontSize = 10;
                                doc.header = function() {
                                    return {
                                        columns: [{
                                                text: 'Rekap Pengaduan',
                                                fontSize: 14,
                                                bold: true,
                                                margin: [20, 10]
                                            },
                                            {
                                                text: 'Tanggal cetak: ' + new Date()
                                                    .toLocaleDateString(),
                                                alignment: 'right',
                                                margin: [0, 10, 20, 0]
                                            }
                                        ]
                                    };
                                };
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print me-1"></i><span>Print</span>',
                            className: 'btn-print',
                            title: 'Rekap Pengaduan',
                        }
                    ]
                });

            });
        </script>
    @endpush
</x-app-layout>
