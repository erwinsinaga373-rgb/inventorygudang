@extends('layouts.app')

@section('content')
<!-- Custom Styles untuk Tema Sage Green Premium Ultra-Modern -->
<style>
    :root {
        --sage-dark: #2C382E;
        --sage-main: #607964;
        --sage-mid: #849E88;
        --sage-light: #A9BFA3;
        --sage-bg-soft: #F4F7F4;
        --sage-gradient-1: linear-gradient(135deg, #738B73 0%, #4A5D4E 100%);
        --sage-gradient-2: linear-gradient(135deg, #A7BBA2 0%, #7E9579 100%);
        --sage-gradient-3: linear-gradient(135deg, #E6DDD6 0%, #C4A48A 100%);
        --sage-gradient-4: linear-gradient(135deg, #BACBB9 0%, #8FA48F 100%);
    }

    /* === SINKRONISASI NAVBAR ATAS STISLA (SAGE GREEN) === */
    body .navbar-bg {
        background: linear-gradient(135deg, #4A5D4E 0%, #2C382E 100%) !important;
        height: 125px !important;
    }
    
    body .main-navbar .nav-link {
        color: #f4f6f4 !important;
    }
    
    body .main-navbar .nav-link:hover,
    body .main-navbar .nav-link.active {
        color: #ffffff !important;
        opacity: 1;
    }

    body .main-navbar .nav-link-user {
        color: #ffffff !important;
        font-weight: 600;
    }

    body .navbar .form-inline .form-control {
        background-color: rgba(255, 255, 255, 0.12) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        border-radius: 30px;
    }

    body .navbar .form-inline .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    body .navbar .form-inline .btn {
        background-color: rgba(255, 255, 255, 0.18) !important;
        color: #ffffff !important;
        border-radius: 30px;
    }
    /* ==================================================== */
    
    /* Global Section Text */
    .section-header h1 {
        color: var(--sage-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
    }

    /* Premium Glass-Card Style */
    .card-premium {
        border: none !important;
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(96, 121, 100, 0.04) !important;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    .card-premium:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(96, 121, 100, 0.12) !important;
    }

    /* Metric Layout Styling */
    .metric-label {
        color: #8A9A8E;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .metric-value {
        font-weight: 800; 
        font-size: 2rem;
        letter-spacing: -0.5px;
        line-height: 1.1;
    }

    /* Dynamic Icon Wrappers with Gradients */
    .icon-wrapper-dynamic {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #ffffff !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
        transition: all 0.4s ease;
    }

    .card-premium:hover .icon-wrapper-dynamic {
        transform: scale(1.1) rotate(6deg);
    }

    /* Soft Pill Badges */
    .badge-sage-alert {
        background-color: rgba(214, 158, 46, 0.12) !important;
        color: #A07216 !important;
        font-weight: 700;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 12px;
    }

    /* Luxury Table Interface */
    .table-modern {
        border-collapse: separate;
        border-spacing: 0 6px;
    }

    .table-modern thead th {
        border: none !important;
        color: var(--sage-dark);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.8px;
        background-color: var(--sage-bg-soft);
        padding: 14px;
    }

    .table-modern tbody td {
        padding: 14px !important;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f1 !important;
        border-bottom: 1px solid #f1f5f1 !important;
        color: #4A534D;
    }

    .table-modern tbody tr td:first-child {
        border-left: 1px solid #f1f5f1 !important;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .table-modern tbody tr td:last-child {
        border-right: 1px solid #f1f5f1 !important;
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .table-modern tbody tr:hover td {
        background-color: var(--sage-bg-soft) !important;
    }

    .card-title-premium {
        font-size: 18px;
        font-weight: 800;
        color: var(--sage-dark);
        letter-spacing: -0.3px;
    }
</style>

<div class="section-header mb-4">
    <h1>Dashboard Utama</h1>
</div>

<!-- BARIS UTAMA LAYOUT BARU ASIMETRIS -->
<div class="row">
    
    <!-- KOLOM KIRI: GRAFIK DATA (LEBIH LEBAR DAN DOMINAN) -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card card-premium h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title-premium mb-0">Grafik Arus Barang</h5>
                    <p class="text-muted small mb-0">Visualisasi realtime komparasi logistik bulanan</p>
                </div>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div style="position: relative; height: 340px;">
                    <canvas id="summaryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: RINGKASAN DATA STATISTIK KELOMPOK -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="row h-100">
            <!-- Semua Barang -->
            <div class="col-md-6 col-lg-12 mb-4">
                <div class="card card-premium p-3 h-100 d-flex justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="metric-label text-uppercase d-block mb-1">Semua Barang</span>
                            <h2 class="metric-value mb-0" style="color: var(--sage-dark)">{{ $barang }}</h2>
                        </div>
                        <div class="icon-wrapper-dynamic" style="background: var(--sage-gradient-1);">
                            <i class="fas fa-cubes"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Barang Masuk -->
            <div class="col-md-6 col-lg-12 mb-4">
                <div class="card card-premium p-3 h-100 d-flex justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="metric-label text-uppercase d-block mb-1">Barang Masuk</span>
                            <h2 class="metric-value mb-0" style="color: var(--sage-main);">{{ $barangMasuk }}</h2>
                        </div>
                        <div class="icon-wrapper-dynamic" style="background: var(--sage-gradient-2);">
                            <i class="fas fa-file-import"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Barang Keluar -->
            <div class="col-md-6 col-lg-12 mb-4">
                <div class="card card-premium p-3 h-100 d-flex justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="metric-label text-uppercase d-block mb-1">Barang Keluar</span>
                            <h2 class="metric-value mb-0" style="color: #BA845D;">{{ $barangKeluar }}</h2>
                        </div>
                        <div class="icon-wrapper-dynamic" style="background: var(--sage-gradient-3);">
                            <i class="fas fa-file-export"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pengguna -->
            <div class="col-md-6 col-lg-12 mb-4">
                <div class="card card-premium p-3 h-100 d-flex justify-content-center">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="metric-label text-uppercase d-block mb-1">Pengguna</span>
                            <h2 class="metric-value mb-0" style="color: var(--sage-mid);">{{ $user }}</h2>
                        </div>
                        <div class="icon-wrapper-dynamic" style="background: var(--sage-gradient-4);">
                            <i class="far fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BARIS KEDUA LAYOUT: TABEL MONITORING UTUH -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card card-premium">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                <h5 class="card-title-premium mb-0">Stok Mencapai Batas Minimum</h5>
                <p class="text-muted small mb-0">Daftar inventaris kritis yang direkomendasikan untuk segera melakukan pengisian ulang (restock)</p>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="8%">No</th>
                                <th scope="col" width="20%">Kode Produk</th>
                                <th scope="col">Nama Barang/Inventaris</th>
                                <th scope="col" width="15%" class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMinimum as $barang)
                                <tr>
                                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">{{ $loop->iteration }}</span></td>
                                    <td class="font-weight-bold" style="color: var(--sage-main); font-size: 13px;">{{ $barang->kode_barang }}</td>
                                    <td style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">{{ $barang->nama_barang }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-sage-alert"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $barang->stok }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-check-circle mb-3 d-block" style="font-size: 40px; color: var(--sage-light);"></i>
                                        <span style="font-size: 15px; font-weight: 500; color: var(--sage-main)">Kondisi Gudang Prima! Seluruh stok barang aman.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('summaryChart').getContext('2d');
        
        var gradientMasuk = ctx.createLinearGradient(0, 0, 0, 320);
        gradientMasuk.addColorStop(0, '#607964');
        gradientMasuk.addColorStop(1, 'rgba(169, 191, 163, 0.2)');

        var gradientKeluar = ctx.createLinearGradient(0, 0, 0, 320);
        gradientKeluar.addColorStop(0, '#BACBB9');
        gradientKeluar.addColorStop(1, 'rgba(232, 239, 233, 0.1)');

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($barangMasukData as $data)
                        '{{ date("M", strtotime($data->date)) }}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: [
                            @foreach($barangMasukData as $data)
                                '{{ $data->total }}',
                            @endforeach
                        ],
                        backgroundColor: gradientMasuk,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.4,
                        categoryPercentage: 0.6
                    },
                    {
                        label: 'Barang Keluar',
                        data: [
                            @foreach($barangKeluarData as $data)
                                '{{ $data->total }}',
                            @endforeach
                        ],
                        backgroundColor: gradientKeluar,
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.4,
                        categoryPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 6,
                            boxHeight: 6,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '600', family: "'Inter', sans-serif" }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#8A9A8E', font: { size: 11, weight: '600' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#EDF2EE', drawBorder: false },
                        ticks: {
                            precision: 0,
                            stepSize: 1,
                            color: '#8A9A8E',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush