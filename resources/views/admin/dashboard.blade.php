<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-1">MSJ REKAP TAGIHAN</h6>
                        <p class="text-sm">Selamat datang di halaman dashboard Rekap Tagihan!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Vendor Baru</p>
                                    <h5 class="font-weight-bolder">+0</h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+0%</span>
                                        1 bulan terakhir
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-primary text-center rounded-circle"
                                    style="background: linear-gradient(45deg, #0b7c0f, #8bb55b,  #f9ff42);">
                                    <i class="fas fa-truck text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Bank Baru</p>
                                    <h5 class="font-weight-bolder">+0</h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+0%</span> 3 bulan
                                        terakhir
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-primary text-center rounded-circle"
                                    style="background: linear-gradient(45deg, #051b60, #52aeff,  #c1c2ba);">
                                    <i class="fas fa-building-columns opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currency -->
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Currency Baru</p>
                                    <h5 class="font-weight-bolder">+0</h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+0%</span> 3 bulan
                                        terakhir
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-primary text-center rounded-circle"
                                    style="background: linear-gradient(45deg, #724c05, #e8d966,  #b93f3f);">
                                    <i class="fas fa-dollar-sign opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Terima -->
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Detail Tanda Terima</p>
                                    <h5 class="font-weight-bolder">+0</h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+0%</span> 1 bulan
                                        terakhir
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape shadow-warning text-center rounded-circle"
                                    style="background: linear-gradient(45deg, #d324d0, #799ad7,  #e7a0d4);">
                                    <i class="fas fa-print opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Estimasi -->
        <div class="row mt-4">
            <div class="col-sm-6 mb-4">
                <div class="card z-index-2">
                    <div class="card-header p-3 pb-0">
                        <h6>Estimasi Pembayaran Berdasarkan Kategori Pembayaran</h6>
                        <p class="text-sm mb-0">
                            <small class="text-muted">Data diperbarui per -</small>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="bar-chart" class="chart-canvas" height="280"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card z-index-2">
                    <div class="card-header pb-0 p-3">
                        <h6>Estimasi Pembayaran Berdasarkan Department</h6>
                        <p class="text-sm mb-0">
                            <small class="text-muted">Data diperbarui per -</small>
                        </p>
                    </div>
                    <div class="card-body p-1"></div>
                    <div class="chart">
                        <canvas id="pie-chart" class="chart-canvas" height="236"></canvas>
                    </div>
                    <div class="text-center mt-3">
                        <button id="show-others" class="btn btn-outline-primary btn-sm">Lihat Others...</button>
                    </div>
                </div>
            </div>

            <!-- Modal Others -->
            <div class="modal fade" id="othersModal" tabindex="-1" aria-labelledby="othersModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="othersModalLabel">Detail Department Others</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="others-details" class="list-group list-group-flush"></ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kurs dan Progress -->
        <div class="row">
            <div class="col-lg-6 col-md-6 mt-md-3 mt-4">
                <div class="card overflow-hidden" style="height: 100%;">
                    <div class="card-header p-3"
                        style="background: linear-gradient(90deg, #59cf5d, #3da2f4); color: white;">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Kurs Mata Uang Asing</p>
                    </div>
                    <div class="card-body p-3"
                        style="background: linear-gradient(100deg, #59cf5d, #3da2f4); color: white;">
                        <a href="https://datacenter.ortax.org/ortax/kursbi/list" target="_blank"
                            class="btn btn-light">
                            Lihat Kurs Real-Time
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mt-md-3 mt-4">
                <div class="card overflow-hidden" style="height: 100%;">
                    <div class="card-header p-3"
                        style="background: linear-gradient(75deg, #59cf5d, #3da2f4); color: white;">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">TASK TANDA TERIMA PERIODE SATU
                                    BULAN</p>
                                <h5 class="font-weight-bolder mb-0">0</h5>
                            </div>
                            <div class="progress-wrapper ms-auto w-25">
                                <div class="progress-info">
                                    <div class="progress-percentage">
                                        <span class="text-xs font-weight-bold">0%</span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                        aria-valuemax="100" style="width: 0%; background-color: #FFB200;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3"
                        style="margin-top: -14px; background: linear-gradient(75deg, #59cf5d, #3da2f4); color: white;">
                        <div class="chart">
                            <canvas id="chart-tasks" class="chart-canvas" height="60"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <!-- Tambahkan ini setelah semua konten HTML -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fungsi untuk memformat angka ke format Rupiah
        function formatCurrency(value) {
            value = parseFloat(value);
            return value.toLocaleString("id-ID", {
                style: "decimal",
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Dummy data kategori pembayaran
        const kategoriPembayaran = [
            { kategori_pembayaran: "Operasional", nominal: 12000000 },
            { kategori_pembayaran: "Gaji", nominal: 8500000 },
            { kategori_pembayaran: "Listrik", nominal: 4000000 },
            { kategori_pembayaran: "Transportasi", nominal: 3000000 }
        ];
        const kategoriLabels = kategoriPembayaran.map(item => item.kategori_pembayaran);
        const nominalData = kategoriPembayaran.map(item => item.nominal);

        const barCtx = document.getElementById("bar-chart").getContext("2d");
        new Chart(barCtx, {
            type: "bar",
            data: {
                labels: kategoriLabels,
                datasets: [{
                    label: "Total by category",
                    backgroundColor: "#A888B5",
                    data: nominalData,
                    maxBarThickness: 35,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: value => "Rp" + formatCurrency(value),
                            color: "#1B1833",
                            padding: 10,
                        },
                        grid: {
                            display: true,
                            borderDash: [5, 5],
                        },
                    },
                    x: {
                        ticks: {
                            color: "#1B1833",
                            padding: 10,
                        },
                        grid: {
                            display: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => "Rp" + formatCurrency(context.raw || 0)
                        }
                    },
                },
            },
        });

        // Dummy data department (top 3 + others)
        const departmentData = [
            { nama_dept: "HR", nominal: 10000000 },
            { nama_dept: "IT", nominal: 8000000 },
            { nama_dept: "Marketing", nominal: 6000000 },
            { nama_dept: "Keuangan", nominal: 4000000 },
            { nama_dept: "Produksi", nominal: 3500000 },
        ];
        const departmentLabels = departmentData.slice(0, 3).map(item => item.nama_dept).concat("Others");
        const departmentDataValues = [
            departmentData[0].nominal,
            departmentData[1].nominal,
            departmentData[2].nominal,
            departmentData.slice(3).reduce((sum, item) => sum + item.nominal, 0)
        ];

        const otherDepartments = departmentData.slice(3);

        const showOthersButton = document.getElementById("show-others");
        const othersModal = new bootstrap.Modal(document.getElementById("othersModal"));
        const othersDetailsList = document.getElementById("others-details");

        showOthersButton.addEventListener("click", () => {
            othersDetailsList.innerHTML = "";
            if (otherDepartments.length > 0) {
                otherDepartments.forEach(item => {
                    const listItem = document.createElement("li");
                    listItem.className = "list-group-item";
                    listItem.textContent = `${item.nama_dept}: Rp ${formatCurrency(item.nominal)}`;
                    othersDetailsList.appendChild(listItem);
                });
            } else {
                const noDataItem = document.createElement("li");
                noDataItem.className = "list-group-item text-center";
                noDataItem.textContent = "Tidak ada data lainnya.";
                othersDetailsList.appendChild(noDataItem);
            }
            othersModal.show();
        });

        const pieCtx = document.getElementById("pie-chart").getContext("2d");
        new Chart(pieCtx, {
            type: "pie",
            data: {
                labels: departmentLabels,
                datasets: [{
                    data: departmentDataValues,
                    backgroundColor: ["#FF6384", "#80C4E9", "#FFCE56", "#B59F78"],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "top"
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const label = tooltipItem.label || '';
                                const value = tooltipItem.raw || 0;
                                return `${label}: Rp ${formatCurrency(value)}`;
                            }
                        }
                    }
                }
            }
        });

        // Dummy data jumlah tanda terima per bulan
        const jumlahTandaTerima = [
            { bulan: "2024-01-01", total: 12 },
            { bulan: "2024-02-01", total: 18 },
            { bulan: "2024-03-01", total: 25 },
            { bulan: "2024-04-01", total: 21 },
            { bulan: "2024-05-01", total: 30 },
            { bulan: "2024-06-01", total: 27 }
        ];
        const bulanLabels = jumlahTandaTerima.map(item =>
            new Date(item.bulan).toLocaleString("id-ID", {
                month: "short",
                year: "numeric"
            })
        );
        const totalData = jumlahTandaTerima.map(item => item.total);

        const lineCtx = document.getElementById("chart-tasks").getContext("2d");
        const gradientStroke = lineCtx.createLinearGradient(0, 230, 0, 50);
        gradientStroke.addColorStop(1, "rgba(29,140,248,0.2)");
        gradientStroke.addColorStop(0.2, "rgba(29,140,248,0.0)");
        gradientStroke.addColorStop(0, "rgba(29,140,248,0)");

        new Chart(lineCtx, {
            type: "line",
            data: {
                labels: bulanLabels,
                datasets: [{
                    label: "Jumlah Daftar Tanda Terima",
                    tension: 0.5,
                    pointRadius: 3,
                    borderWidth: 2,
                    pointBackgroundColor: "#FFF6E9",
                    borderColor: "#FFF6E9",
                    backgroundColor: gradientStroke,
                    data: totalData,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        ticks: {
                            color: "#FFF6E9",
                            padding: 10
                        }
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                },
            },
        });
    </script>
@endpush

    @endpush
</x-app-layout>
