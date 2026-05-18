@extends('layouts.app')

@include('barang-masuk.create')

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

    .btn-premium-sage {
        background: linear-gradient(135deg, #738B73 0%, #4A5D4E 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(74, 93, 78, 0.2) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-sage:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 93, 78, 0.35) !important;
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

    /* Desain Tombol Opsi Mikro */
    .btn-action-premium {
        width: 38px;
        height: 38px;
        border-radius: 10px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px !important;
        padding: 0 !important;
        transition: all 0.2s ease !important;
        border: none !important;
        margin: 0 2px;
    }

    .btn-action-premium:hover {
        transform: translateY(-2px);
    }

    .btn-action-delete { 
        background-color: rgba(220, 53, 69, 0.1) !important; 
        color: #dc3545 !important; 
    }
    .btn-action-delete:hover { 
        background-color: #dc3545 !important; 
        color: #fff !important; 
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
    <h1>Barang Masuk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-sage d-flex align-items-center" id="button_tambah_barangMasuk">
            <i class="fa fa-plus mr-2"></i> Barang Masuk
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="table_id" class="table table-modern display">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No</th>
                                <th scope="col" width="15%">Kode Transaksi</th>
                                <th scope="col" width="15%">Tanggal Masuk</th>
                                <th scope="col" width="25%">Nama Barang</th>
                                <th scope="col" width="15%">Stok Masuk</th>
                                <th scope="col" width="15%">Supplier</th>
                                <th scope="col" width="10%" class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Interface (Select2, Datatable, Auto Code & Ajax Core) -->
<script>
    // Helper pencarian nama supplier
    function getSupplierName(suppliers, supplierId) {
        let supplier = suppliers.find(s => s.id === supplierId);
        return supplier ? supplier.supplier : '';
    }

    // Fungsi Blueprint Row HTML Tabel
    function generateRowHtml(counter, value, supplierName) {
        return `
            <tr class="barang-row" id="index_${value.id}">
                <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                <td style="font-size: 13px; font-weight: 600; color: #4A5D4E;">${value.kode_transaksi}</td>
                <td style="font-size: 13px; color: #6c757d;">${value.tanggal_masuk}</td>
                <td style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.nama_barang}</td>
                <td><span class="badge badge-success px-3 py-2" style="border-radius: 8px; font-weight: 600; background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark);">${value.jumlah_masuk}</span></td>
                <td style="font-size: 13px; color: #4A534D; font-weight: 500;">${supplierName}</td>
                <td class="text-center">
                    <a href="javascript:void(0)" id="button_hapus_barangMasuk" data-id="${value.id}" class="btn btn-action-premium btn-action-delete" title="Hapus"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        `;
    }

    // Fungsi Blueprint Auto-Generate Kode Transaksi
    function generateKodeTransaksi() {
        var tanggal = new Date().toLocaleDateString('id-ID').split('/').reverse().join('-');
        var randomNumber = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
        var kodeTransaksi = 'TRX-IN-' + tanggal + '-' + randomNumber;

        $('#kode_transaksi').val(kodeTransaksi);
        return kodeTransaksi;
    }

    // Fungsi Render Menggunakan AJAX Terpusat
    function loadDataBarangMasuk() {
        $.ajax({
            url: "/barang-masuk/get-data",
            type: "GET",
            dataType: 'JSON',
            success: function(response) {
                let counter = 1;
                $('#table_id').DataTable().clear();
                $.each(response.data, function(key, value) {
                    let supplier = getSupplierName(response.supplier, value.supplier_id);
                    let rowHtml = generateRowHtml(counter++, value, supplier);
                    $('#table_id').DataTable().row.add($(rowHtml)).draw(false);
                });
            }
        });
    }

    $(document).ready(function() {
        // Inisialisasi DataTable Awal
        $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari riwayat transaksi...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Load data pertama kali halaman siap
        loadDataBarangMasuk();
        generateKodeTransaksi();

        // Inisialisasi Otomatis Tanggal Masuk Hari Ini
        var today = new Date();
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0');
        var day = today.getDate().toString().padStart(2, '0');
        $('#tanggal_masuk').val(year + '-' + month + '-' + day);

        // Pengaturan Select2 Autocomplete Autoload
        setTimeout(function() {
            $('.js-example-basic-single').select2();

            $('#nama_barang').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var nama_barang = selectedOption.text();

                $.ajax({
                    url: '/api/barang-masuk',
                    type: 'GET',
                    data: { nama_barang: nama_barang },
                    success: function(response) {
                        if (response && (response.stok || response.stok === 0) && response.satuan_id) {
                            $('#stok').val(response.stok);
                            getSatuanName(response.satuan_id, function(satuan) {
                                $('#satuan_id').val(satuan);
                            });
                        } else if (response && response.stok === 0) {
                            $('#stok').val(0);
                            $('#satuan_id').val('');
                        }
                    }
                });

                function getSatuanName(satuanId, callback) {
                    $.getJSON('{{ url("api/satuan") }}', function(satuans) {
                        var satuan = satuans.find(s => s.id === satuanId);
                        callback(satuan ? satuan.satuan : '');
                    });
                }
            });
        }, 500);

        // Menampilkan Modal Tambah Barang Masuk
        $('body').on('click', '#button_tambah_barangMasuk', function() {
            $('#modal_tambah_barangMasuk').modal('show');
            generateKodeTransaksi();
        });

        // Trigger Eksekusi Simpan Data Barang Masuk (POST)
        $('#store').click(function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('kode_transaksi', $('#kode_transaksi').val());
            formData.append('tanggal_masuk', $('#tanggal_masuk').val());
            formData.append('nama_barang', $('#nama_barang').val());
            formData.append('jumlah_masuk', $('#jumlah_masuk').val());
            formData.append('supplier_id', $('#supplier_id').val());
            formData.append('_token', $("meta[name='csrf-token']").attr("content"));

            // Reset list alert sebelum proses ajax jalan
            $('.alert').removeClass('d-block').addClass('d-none');

            $.ajax({
                url: '/barang-masuk',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // Bersihkan formulir isian setelah data berhasil direkam
                    $('#nama_barang').val('').trigger('change');
                    $('#jumlah_masuk').val('');
                    $('#stok').val('');
                    $('#modal_tambah_barangMasuk').modal('hide');

                    // Refresh data tabel terpusat
                    loadDataBarangMasuk();
                },
                error: function(error) {
                    if (error.responseJSON) {
                        let errors = error.responseJSON;
                        if (errors.kode_transaksi) $('#alert-kode_transaksi').removeClass('d-none').addClass('d-block').html(errors.kode_transaksi[0]);
                        if (errors.tanggal_masuk) $('#alert-tanggal_masuk').removeClass('d-none').addClass('d-block').html(errors.tanggal_masuk[0]);
                        if (errors.nama_barang) $('#alert-nama_barang').removeClass('d-none').addClass('d-block').html(errors.nama_barang[0]);
                        if (errors.jumlah_masuk) $('#alert-jumlah_masuk').removeClass('d-none').addClass('d-block').html(errors.jumlah_masuk[0]);
                        if (errors.supplier_id) $('#alert-supplier_id').removeClass('d-none').addClass('d-block').html(errors.supplier_id[0]);
                    }
                }
            });
        });

        // Trigger Eksekusi Penghapusan Data Barang Masuk (DELETE)
        $('body').on('click', '#button_hapus_barangMasuk', function() {
            let barangMasuk_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "Data transaksi barang masuk ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4A5D4E',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/barang-masuk/${barangMasuk_id}`,
                        type: "DELETE",
                        cache: false,
                        data: { "_token": token },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            // Bersihkan dan render ulang struktur tabel utama
                            loadDataBarangMasuk();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection