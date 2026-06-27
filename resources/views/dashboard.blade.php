@extends('layouts.app')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;        /* Emerald 900 */
        --corp-navy: #022C22;        /* Emerald 950 */
        --corp-muted: #34D399;       /* Emerald 400 */
        --corp-text-muted: #475569;  /* Slate 600 */
        --corp-bg-soft: #F0FDF4;     /* Emerald 50 */
        --corp-border: #DCFCE7;      /* Emerald 100 */
        --corp-green: #059669;       /* Emerald 600 */
        
        /* Gradasi */
        --corp-gradient-1: linear-gradient(135deg, #10B981 0%, #059669 100%);
        --gradient-in: linear-gradient(135deg, #10B981 0%, #047857 100%);
        --gradient-out: linear-gradient(135deg, #F59E0B 0%, #B45309 100%);
        --gradient-user: linear-gradient(135deg, #6B7280 0%, #374151 100%);
    }

    /* === SINKRONISASI NAVBAR ATAS STISLA === */
    body .navbar-bg {
        background: linear-gradient(135deg, #022C22 0%, #064E3B 100%) !important;
        height: 125px !important;
    }
    
    body .main-navbar .nav-link {
        color: #E6F4EA !important;
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
        background-color: rgba(255, 255, 255, 0.15) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        border-radius: 30px;
    }

    body .navbar .form-inline .form-control::placeholder {
        color: rgba(240, 253, 244, 0.6) !important;
    }

    body .navbar .form-inline .btn {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
        border-radius: 30px;
    }
    
    /* Global Section Text */
    .section-header h1 {
        color: var(--corp-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
    }

    /* Premium Card Structure */
    .card-premium {
        border: none !important;
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(2, 44, 34, 0.03) !important;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    .card-premium:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(2, 44, 34, 0.07) !important;
    }

    /* Metric Layout Styling */
    .metric-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .metric-value {
        font-weight: 800; 
        font-size: 2.2rem;
        letter-spacing: -0.5px;
        line-height: 1.1;
    }

    /* Dynamic Icon Wrappers */
    .icon-wrapper-dynamic {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #ffffff !important;
        box-shadow: 0 8px 20px rgba(2, 44, 34, 0.1);
        transition: all 0.4s ease;
    }

    .card-premium:hover .icon-wrapper-dynamic {
        transform: scale(1.1) rotate(6deg);
    }

    /* Soft Pill Badges */
    .badge-corporate-alert {
        background-color: rgba(239, 68, 68, 0.1) !important;
        color: #DC2626 !important;
        font-weight: 700;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 12px;
    }

    /* Luxury Table Interface */
    .table-modern {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100% !important;
    }

    .table-modern thead th {
        border: none !important;
        color: var(--corp-dark) !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        font-size: 11px !important;
        letter-spacing: 0.8px !important;
        background-color: var(--corp-bg-soft) !important;
        padding: 16px 14px !important;
    }

    .table-modern tbody td {
        padding: 14px !important;
        vertical-align: middle !important;
        border-top: 1px solid var(--corp-border) !important;
        border-bottom: 1px solid var(--corp-border) !important;
        color: #064E3B;
        background: #ffffff;
    }

    .table-modern tbody tr td:first-child {
        border-left: 1px solid var(--corp-border) !important;
        border-top-left-radius: 16px !important;
        border-bottom-left-radius: 16px !important;
    }

    .table-modern tbody tr td:last-child {
        border-right: 1px solid var(--corp-border) !important;
        border-top-right-radius: 16px !important;
        border-bottom-right-radius: 16px !important;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover td {
        background-color: var(--corp-bg-soft) !important;
        border-color: #A7F3D0 !important;
    }

    .card-title-premium {
        font-size: 18px;
        font-weight: 800;
        color: var(--corp-dark);
        letter-spacing: -0.3px;
    }
</style>

<div class="section-header mb-4">
    <h1>Dashboard Utama</h1>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card card-premium">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title-premium mb-0">Tren Arus Logistik</h5>
                    <p class="text-muted small mb-0">Visualisasi fluktuasi bulanan distribusi barang masuk dan keluar secara realtime</p>
                </div>
            </div>
            <div class="card-body px-4 pb-3 pt-2">
                <div style="position: relative; height: 340px;">
                    <canvas id="summaryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-3 col-sm-6 mb-4 mb-xl-0">
        <div class="card card-premium p-4 h-100" style="background: linear-gradient(to bottom right, #E6F4EA, #ffffff);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="metric-label text-uppercase d-block mb-1" style="color: #059669;">Semua Barang</span>
                    <h2 class="metric-value mb-0" style="color: #064E3B;">{{ $barang }}</h2>
                </div>
                <div class="icon-wrapper-dynamic" style="background: var(--corp-gradient-1);">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 mb-4 mb-xl-0">
        <div class="card card-premium p-4 h-100" style="background: linear-gradient(to bottom right, #ECFDF5, #ffffff);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="metric-label text-uppercase d-block mb-1" style="color: #10B981;">Barang Masuk</span>
                    <h2 class="metric-value mb-0" style="color: #047857;">{{ $barangMasuk }}</h2>
                </div>
                <div class="icon-wrapper-dynamic" style="background: var(--gradient-in);">
                    <i class="fas fa-file-import"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6 mb-4 mb-sm-0">
        <div class="card card-premium p-4 h-100" style="background: linear-gradient(to bottom right, #FFFBEB, #ffffff);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="metric-label text-uppercase d-block mb-1" style="color: #D97706;">Barang Keluar</span>
                    <h2 class="metric-value mb-0" style="color: #78350F;">{{ $barangKeluar }}</h2>
                </div>
                <div class="icon-wrapper-dynamic" style="background: var(--gradient-out);">
                    <i class="fas fa-file-export"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-sm-6">
        <div class="card card-premium p-4 h-100" style="background: linear-gradient(to bottom right, #F8FAFC, #ffffff);">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="metric-label text-uppercase d-block mb-1" style="color: #64748B;">Pengguna</span>
                    <h2 class="metric-value mb-0" style="color: #0F172A;">{{ $user }}</h2>
                </div>
                <div class="icon-wrapper-dynamic" style="background: var(--gradient-user);">
                    <i class="far fa-user"></i>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                <th scope="col" width="25%">Kode Produk</th>
                                <th scope="col">Nama Barang/Inventaris</th>
                                <th scope="col" width="15%" class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMinimum as $barang)
                                <tr>
                                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">{{ $loop->iteration }}</span></td>
                                    <td class="font-weight-bold" style="color: #059669; font-size: 13px;">{{ $barang->kode_barang }}</td>
                                    <td style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">{{ $barang->nama_barang }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-corporate-alert"><i class="fas fa-exclamation-triangle mr-1"></i> {{ $barang->stok }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-check-circle mb-3 d-block" style="font-size: 40px; color: #10B981;"></i>
                                        <span style="font-size: 15px; font-weight: 500; color: #047857;">Kondisi Gudang Prima! Seluruh stok barang aman.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="card card-premium">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                <h5 class="card-title-premium mb-0 text-danger">Stok Melebihi Batas Maksimum</h5>
                <p class="text-muted small mb-0">Daftar inventaris yang melebihi kapasitas batas maksimum penyimpanan gudang (Overstock)</p>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="8%">No</th>
                                <th scope="col" width="25%">Kode Produk</th>
                                <th scope="col">Nama Barang/Inventaris</th>
                                <th scope="col" width="15%" class="text-center">Kelebihan Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMaksimum as $barang)
                                <tr>
                                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">{{ $loop->iteration }}</span></td>
                                    <td class="font-weight-bold" style="color: #059669; font-size: 13px;">{{ $barang->kode_barang }}</td>
                                    <td style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">{{ $barang->nama_barang }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-corporate-alert" style="background-color: rgba(239, 68, 68, 0.15) !important;">
                                            <i class="fas fa-boxes mr-1"></i> Over {{ $barang->stok - $barang->stok_maksimum }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-check-circle mb-3 d-block" style="font-size: 40px; color: #10B981;"></i>
                                        <span style="font-size: 15px; font-weight: 500; color: #047857;">Kapasitas Bagus! Tidak ada barang yang mengalami overstock.</span>
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
        gradientMasuk.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
        gradientMasuk.addColorStop(1, 'rgba(16, 185, 129, 0.00)');

        var gradientKeluar = ctx.createLinearGradient(0, 0, 0, 320);
        gradientKeluar.addColorStop(0, 'rgba(245, 158, 11, 0.20)');
        gradientKeluar.addColorStop(1, 'rgba(245, 158, 11, 0.00)');

        var chart = new Chart(ctx, {
            type: 'line',
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
                        borderColor: '#10B981',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10B981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Barang Keluar',
                        data: [
                            @foreach($barangKeluarData as $data)
                                '{{ $data->total }}',
                            @endforeach
                        ],
                        backgroundColor: gradientKeluar,
                        borderColor: '#F59E0B',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#F59E0B',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif", size: 11, weight: '500' }, color: '#64748B' }
                    },
                    y: {
                        grid: { color: 'rgba(220, 252, 231, 0.25)' },
                        border: { display: false },
                        ticks: { font: { family: "'Inter', sans-serif", size: 11 }, color: '#64748B' }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 8,
                            boxHeight: 8,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { size: 12, weight: '600', family: "'Inter', sans-serif" }
                        }
                    },
                    tooltip: {
                        padding: 14,
                        backgroundColor: '#022C22',
                        titleFont: { family: "'Inter', sans-serif", weight: '700', size: 13 },
                        bodyFont: { family: "'Inter', sans-serif", size: 12 },
                        cornerRadius: 16,
                        usePointStyle: true,
                        boxWidth: 6,
                        boxHeight: 6
                    }
                }
            }
        });
    });
</script>
@endpush