@extends('layouts.app')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;        /* Emerald 900 - Teks utama & judul */
        --corp-navy: #022C22;        /* Emerald 950 - Topbar / Sisi aktif */
        --corp-muted: #34D399;       /* Emerald 400 - Teks sekunder */
        --corp-bg-soft: #F0FDF4;     /* Emerald 50 - Background panel & baris hover */
        --corp-border: #DCFCE7;      /* Emerald 100 - Batas border ringan */
        --corp-green: #059669;       /* Emerald 600 - Aksentuasi utama */
        
        --corp-gradient-1: linear-gradient(135deg, #10B981 0%, #059669 100%);
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

    /* Global Section Text & Buttons */
    .section-header h1 {
        color: var(--corp-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
    }

    /* Tombol cetak dengan aksen merah premium kontras agar stand-out */
    .btn-premium-print {
        background: linear-gradient(135deg, #E06C75 0%, #C2414C 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(194, 65, 76, 0.2) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(194, 65, 76, 0.35) !important;
        opacity: 0.95;
    }

    .btn-premium-emerald {
        background: var(--corp-gradient-1) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-emerald:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.25) !important;
    }

    .btn-premium-secondary {
        background: var(--corp-border) !important;
        color: var(--corp-dark) !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-secondary:hover {
        background: var(--corp-muted) !important;
        color: #ffffff !important;
    }

    /* Premium Card Structure */
    .card-premium {
        border: none !important;
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(2, 44, 34, 0.03) !important;
        overflow: hidden;
    }

    /* Luxury Form Control */
    .form-group label {
        color: var(--corp-dark) !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
    }

    .form-control-premium {
        border: 2px solid var(--corp-border) !important;
        border-radius: 12px !important;
        height: 46px !important;
        font-weight: 600 !important;
        color: var(--corp-dark) !important;
        background-color: #FAFCFA !important;
        transition: all 0.3s ease !important;
    }

    .form-control-premium:focus {
        border-color: var(--corp-muted) !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.15) !important;
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

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--corp-gradient-1) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px;
    }
</style>

<div class="section-header mb-4">
    <h1>Laporan Barang Masuk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-print d-flex align-items-center" id="print-barang-masuk">
            <i class="fa fa-print mr-2"></i> Print PDF
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium mb-4">
            <div class="card-body p-4">
                <form id="filter_form" action="/laporan-barang-masuk/get-data" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-5 form-group mb-3 mb-md-0">
                            <label for="tanggal_mulai">Pilih Tanggal Mulai :</label>
                            <input type="date" class="form-control form-control-premium" name="tanggal_mulai" id="tanggal_mulai">
                        </div>
                        <div class="col-md-5 form-group mb-3 mb-md-0">
                            <label for="tanggal_selesai">Pilih Tanggal Selesai :</label>
                            <input type="date" class="form-control form-control-premium" name="tanggal_selesai" id="tanggal_selesai">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-premium-emerald btn-block h-100 py-3 mr-2">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button type="button" class="btn btn-premium-secondary btn-block h-100 py-3 m-0" id="refresh_btn">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="table_id" class="table table-modern display">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No</th>
                                <th scope="col" width="15%">Kode Transaksi</th>
                                <th scope="col" width="15%">Tanggal Masuk</th>
                                <th scope="col" width="30%">Nama Barang</th>
                                <th scope="col" width="15%">Jumlah Masuk</th>
                                <th scope="col" width="20%">Supplier</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-laporan-barang-masuk">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi Awal Struktur DataTables Premium
        var table = $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data laporan masuk...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Load Data Default Pertama Kali
        loadData();

        // Event Trigger saat Filter Form disubmit
        $('#filter_form').submit(function(event) {
            event.preventDefault();
            loadData();
        });

        // Event Trigger saat Tombol Refresh ditekan
        $('#refresh_btn').on('click', function() {
            refreshTable();
        });

        // Core Rendering Engine Laporan Barang Masuk
        function loadData() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();

            $.ajax({
                url: '/laporan-barang-masuk/get-data',
                type: 'GET',
                dataType: 'json',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                },
                success: function(response) {
                    table.clear().draw();

                    if (response.length > 0) {
                        let counter = 1;
                        $.each(response, function(index, item) {
                            getSupplierName(item.supplier_id, function(supplier) {
                                // Mengemas komponen HTML ke dalam struktur baris DataTables dengan Skema Emerald
                                // Badge jumlah masuk menggunakan warna hijau transparan penanda stok bertambah (+), berbeda dengan barang keluar
                                var rowNode = table.row.add([
                                    `<span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span>`,
                                    `<span style="font-size: 13px; font-weight: 600; color: #059669;">${item.kode_transaksi}</span>`,
                                    `<span style="font-size: 13px; color: #6c757d;">${item.tanggal_masuk}</span>`,
                                    `<span style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">${item.nama_barang}</span>`,
                                    `<span class="badge px-3 py-2" style="border-radius: 8px; font-weight: 700; background-color: rgba(16, 185, 129, 0.15); color: #059669;">${item.jumlah_masuk}</span>`,
                                    `<span style="font-size: 13px; color: #064E3B; font-weight: 500;">${supplier}</span>`
                                ]).draw(false).node();

                                // Menambahkan ID unik dan class row custom
                                $(rowNode).attr('id', `index_${item.id}`).addClass('barang-row');
                            });
                        });
                    } else {
                        table.clear().draw();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        // Helper Pencarian Nama Supplier Via API
        function getSupplierName(supplierId, callback) {
            $.getJSON('{{ url("api/supplier") }}', function(suppliers) {
                var supplier = suppliers.find(function(s) {
                    return s.id === supplierId;
                });
                callback(supplier ? supplier.supplier : '');
            });
        }

        // Fungsi Reset Form Filter
        function refreshTable() {
            $('#filter_form')[0].reset();
            loadData();
        }

        // Redirect Engine untuk Export PDF Cetak Laporan
        $('#print-barang-masuk').on('click', function() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();

            var url = '/laporan-barang-masuk/print-barang-masuk';

            if (tanggalMulai && tanggalSelesai) {
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }

            window.location.href = url;
        });
    });
</script>
@endsection