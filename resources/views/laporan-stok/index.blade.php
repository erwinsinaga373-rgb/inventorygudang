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

    /* Penyesuaian Input Cari DataTables Premium agar Sinkron */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--corp-border) !important;
        border-radius: 10px !important;
        padding: 6px 14px !important;
        background-color: var(--corp-bg-soft) !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none !important;
        border-color: var(--corp-green) !important;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1) !important;
    }
</style>

<div class="section-header mb-4">
    <h1>Laporan Stok</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-print d-flex align-items-center" id="print-stok">
            <i class="fa fa-print mr-2"></i> Print PDF
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium mb-4">
            <div class="card-body p-4">
                <div class="form-group mb-0">
                    <label for="opsi-laporan-stok">Filter Stok Berdasarkan :</label>
                    <select class="form-control form-control-premium" name="opsi-laporan-stok" id="opsi-laporan-stok">
                        <option value="semua" selected>Semua Barang</option>
                        <option value="minimum">Batas Minimum</option>
                        <option value="maksimum">Batas Maksimum</option>
                        <option value="stok-habis">Stok Habis</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="table_id" class="table table-modern display">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No</th>
                                <th scope="col" width="15%">Kode Barang</th>
                                <th scope="col" width="35%">Nama Barang</th>
                                <th scope="col" width="15%">Stok Minimum</th>
                                <th scope="col" width="15%">Stok Maksimum</th>
                                <th scope="col" width="15%">Stok Saat Ini</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-laporan-stok">
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
                search: "",
                searchPlaceholder: "Cari data laporan stok...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Memaksa input search DataTables agar merespon setiap ketikan keyboard secara aman
        $('.dataTables_filter input').unbind().bind('keyup', function() {
            table.search(this.value).draw();
        });

        // Load Data Default Pertama Kali
        loadData('semua');

        // Event Trigger saat Filter Dropdown Diganti
        $('#opsi-laporan-stok').on('change', function(){
            var selectedOption = $(this).val();
            loadData(selectedOption);
        });

        // Core Rendering Engine untuk Manipulasi Array DataTables secara Aman
        function loadData(selectedOption) {
            $.ajax({
                url: '/laporan-stok/get-data',
                type: 'GET',
                data: { opsi: selectedOption },
                success: function(response){
                    table.clear();

                    let counter = 1;
                    $.each(response, function(index, item) {
                        // Konversi nilai ke bentuk Integer untuk komparasi angka matematis yang akurat
                        let currentStok = parseInt(item.stok) || 0;
                        let minStok = parseInt(item.stok_minimum) || 0;
                        let maxStok = parseInt(item.stok_maksimum) || 0; // ADDED: Ambil variabel stok_maksimum

                        // Logika Pewarnaan Badge Dinamis Mengikuti Aturan Batas Limit Stok
                        let badgeStyle = '';
                        
                        if (currentStok === 0 || selectedOption === 'stok-habis') {
                            // Badge merah halus untuk stok yang benar-benar habis kosong
                            badgeStyle = 'background-color: rgba(220, 53, 69, 0.12); color: #dc3545; border-radius: 8px; font-weight: 700;';
                        } else if (currentStok <= minStok || selectedOption === 'minimum') {
                            // Badge oranye/kuning hangat jika stok saat ini sudah MENYENTUH atau MELEWATI batas minimum
                            badgeStyle = 'background-color: rgba(245, 158, 11, 0.15); color: #D97706; border-radius: 8px; font-weight: 700;';
                        } else if (currentStok >= maxStok || selectedOption === 'maksimum') {
                            // ADDED: Badge Indigo/Ungu mewah jika stok sudah MENYENTUH atau MELEBIHI batas maksimum (Overstock)
                            badgeStyle = 'background-color: rgba(99, 102, 241, 0.15); color: #4F46E5; border-radius: 8px; font-weight: 700;';
                        } else {
                            // Badge emerald segar untuk kondisi stok yang masih aman kondusif di antara limit min & max
                            badgeStyle = 'background-color: #D1FAE5; color: #065F46; border-radius: 8px; font-weight: 700;';
                        }

                        // FIXED: Mengemas komponen HTML ke dalam Array Row DataTables (Total harus pas 6 kolom sesuai <th>)
                        var rowNode = table.row.add([
                            `<span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span>`,
                            `<span style="font-size: 13px; font-weight: 600; color: #059669;">${item.kode_barang}</span>`,
                            `<span style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">${item.nama_barang}</span>`,
                            `<span class="badge px-3 py-2" style="background-color: #E0F2FE; color: #0369A1; border-radius: 8px; font-weight: 700;">${minStok}</span>`, // Batas Minimum (Biru Soft)
                            `<span class="badge px-3 py-2" style="background-color: #F3E8FF; color: #6B21A8; border-radius: 8px; font-weight: 700;">${maxStok}</span>`, // ADDED: Batas Maksimum (Ungu Soft)
                            `<span class="badge px-3 py-2" style="${badgeStyle}">${currentStok}</span>`
                        ]).draw(false).node();

                        // Menambahkan ID unik baris untuk mempermudah tracking elemen DOM
                        $(rowNode).attr('id', `index_${item.id}`).addClass('barang-row');
                    });
                    
                    table.draw();
                }
            });
        }

        // Redirect Engine untuk Export PDF Cetak Laporan
        $('#print-stok').on('click', function(){
            var selectedOption = $('#opsi-laporan-stok').val();
            window.location.href = '/laporan-stok/print-stok?opsi=' + selectedOption;
        });
    });
</script>
@endsection