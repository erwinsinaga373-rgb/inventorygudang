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

    /* Global Section Text & Buttons */
    .section-header h1 {
        color: var(--sage-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
    }

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
        box-shadow: 0 10px 30px rgba(96, 121, 100, 0.04) !important;
        overflow: hidden;
    }

    /* Luxury Form Control */
    .form-group label {
        color: var(--sage-dark) !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
    }

    .form-control-premium {
        border: 2px solid #E8EFE9 !important;
        border-radius: 12px !important;
        height: 46px !important;
        font-weight: 600 !important;
        color: var(--sage-dark) !important;
        background-color: #FAFCFA !important;
        transition: all 0.3s ease !important;
    }

    .form-control-premium:focus {
        border-color: var(--sage-mid) !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(132, 158, 136, 0.15) !important;
    }

    /* Luxury Table Interface */
    .table-modern {
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
        width: 100% !important;
    }

    .table-modern thead th {
        border: none !important;
        color: var(--sage-dark) !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        font-size: 11px !important;
        letter-spacing: 0.8px !important;
        background-color: var(--sage-bg-soft) !important;
        padding: 16px 14px !important;
    }

    .table-modern tbody td {
        padding: 14px !important;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f1 !important;
        border-bottom: 1px solid #f1f5f1 !important;
        color: #4A534D;
        background: #ffffff;
    }

    .table-modern tbody tr td:first-child {
        border-left: 1px solid #f1f5f1 !important;
        border-top-left-radius: 16px !important;
        border-bottom-left-radius: 16px !important;
    }

    .table-modern tbody tr td:last-child {
        border-right: 1px solid #f1f5f1 !important;
        border-top-right-radius: 16px !important;
        border-bottom-right-radius: 16px !important;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover td {
        background-color: var(--sage-bg-soft) !important;
        border-color: var(--sage-light) !important;
    }

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #738B73 0%, #4A5D4E 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px;
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
        <!-- Card Filter Parameter -->
        <div class="card card-premium mb-4">
            <div class="card-body p-4">
                <div class="form-group mb-0">
                    <label for="opsi-laporan-stok">Filter Stok Berdasarkan :</label>
                    <select class="form-control form-control-premium" name="opsi-laporan-stok" id="opsi-laporan-stok">
                        <option value="semua" selected>Semua Barang</option>
                        <option value="minimum">Batas Minimum</option>
                        <option value="stok-habis">Stok Habis</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card Tabel Utama -->
        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="table_id" class="table table-modern display">
                        <thead>
                            <tr>
                                <th scope="col" width="8%">No</th>
                                <th scope="col" width="22%">Kode Barang</th>
                                <th scope="col" width="45%">Nama Barang</th>
                                <th scope="col" width="25%">Stok Saat Ini</th>
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

<!-- Core Engine Scripts DataTables & AJAX Integration -->
<script>
    $(document).ready(function() {
        // Inisialisasi Awal Struktur DataTables Premium
        var table = $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data laporan stok...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
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
                    table.clear().draw();

                    let counter = 1;
                    $.each(response, function(index, item) {
                        // Logika Pewarnaan Badge Dinamis Mengikuti Status Real-time Stok
                        let badgeClass = 'badge-success';
                        let badgeStyle = 'background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark); border-radius: 8px; font-weight: 700;';
                        
                        if (parseInt(item.stok) === 0 || selectedOption === 'stok-habis') {
                            badgeClass = 'badge-danger';
                            badgeStyle = 'background-color: rgba(220, 53, 69, 0.15); color: #dc3545; border-radius: 8px; font-weight: 700;';
                        } else if (selectedOption === 'minimum') {
                            badgeClass = 'badge-warning';
                            badgeStyle = 'background-color: rgba(255, 193, 7, 0.15); color: #ffc107; border-radius: 8px; font-weight: 700;';
                        }

                        // Mengemas komponen HTML ke dalam Array Row DataTables
                        var rowNode = table.row.add([
                            `<span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span>`,
                            `<span style="font-size: 13px; font-weight: 600; color: #4A5D4E;">${item.kode_barang}</span>`,
                            `<span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${item.nama_barang}</span>`,
                            `<span class="badge ${badgeClass} px-3 py-2" style="${badgeStyle}">${item.stok}</span>`
                        ]).draw(false).node();

                        // Menambahkan ID unik baris agar mempermudah tracking elemen DOM jika diperlukan
                        $(rowNode).attr('id', `index_${item.id}`).addClass('barang-row');
                     vote});
                    
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