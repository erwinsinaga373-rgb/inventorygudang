@extends('layouts.app')

@include('supplier.create')
@include('supplier.edit')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;        /* Emerald 900 - Untuk teks utama/judul */
        --corp-navy: #022C22;        /* Emerald 950 - Untuk Topbar / Sisi aktif */
        --corp-muted: #34D399;       /* Emerald 400 - Untuk teks sekunder */
        --corp-bg-soft: #F0FDF4;     /* Emerald 50 - Background utama bersih */
        --corp-border: #DCFCE7;      /* Emerald 100 - Garis pembatas ringan */
        --corp-green: #059669;       /* Emerald 600 - Warna aksen utama */
        
        --corp-gradient-1: linear-gradient(135deg, #10B981 0%, #059669 100%); /* Emerald Pro */
    }

    /* === SINKRONISASI NAVBAR ATAS STISLA (MODERN CORPORATE EMERALD) === */
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

    .btn-premium-corp {
        background: var(--corp-gradient-1) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-corp:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35) !important;
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
    
    .btn-action-edit { background-color: rgba(255, 193, 7, 0.1) !important; color: #ffc107 !important; }
    .btn-action-edit:hover { background-color: #ffc107 !important; color: #fff !important; }

    .btn-action-delete { background-color: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; }
    .btn-action-delete:hover { background-color: #dc3545 !important; color: #fff !important; }

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--corp-gradient-1) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px;
    }
</style>

<div class="section-header mb-4">
    <h1>Data Supplier</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-corp d-flex align-items-center" id="button_tambah_supplier">
            <i class="fa fa-plus mr-2"></i> Tambah Supplier
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
                                <th scope="col" width="10%">No</th>
                                <th scope="col" width="35%">Nama Perusahaan</th>
                                <th scope="col" width="40%">Alamat</th>
                                <th scope="col" width="15%" class="text-center">Opsi</th>
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

<script>
    $(document).ready(function() {
        // Inisialisasi Awal DataTable
        $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari supplier...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Fungsi Blueprint Row HTML
        function generateRowHtml(counter, value) {
            return `
                <tr class="barang-row" id="index_${value.id}">
                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                    <td style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">${value.supplier}</td>
                    <td style="font-size: 13px; color: #047857; font-weight: 500;">${value.alamat}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-edit button_edit_supplier" title="Ubah"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-delete button_hapus_supplier" title="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        }

        // Fungsi Load Data Menggunakan AJAX
        function loadDataSupplier() {
            $.ajax({
                url: "/supplier/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let rowHtml = generateRowHtml(counter++, value);
                        $('#table_id').DataTable().row.add($(rowHtml)).draw(false);
                    });
                }
            });
        }

        // Panggil saat halaman siap
        loadDataSupplier();

        // Trigger Show Modal Tambah
        $('body').on('click', '#button_tambah_supplier', function() {
            $('#modal_tambah_supplier').modal('show');
        });

        // Aksi Simpan Data Supplier Baru
        $('#store').click(function(e) {
            e.preventDefault();

            let supplier = $('#supplier').val();
            let alamat = $('#alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('supplier', supplier);
            formData.append('alamat', alamat);
            formData.append('_token', token);

            // Bersihkan error alert terdahulu
            $('#alert-supplier').removeClass('d-block').addClass('d-none');
            $('#alert-alamat').removeClass('d-block').addClass('d-none');

            $.ajax({
                url: '/supplier',
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

                    // Reset form inputan dan tutup modal
                    $('#supplier').val('');
                    $('#alamat').val('');
                    $('#modal_tambah_supplier').modal('hide');
                    
                    // Reload ulang tabel secara asinkronus
                    loadDataSupplier();
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.supplier) {
                        $('#alert-supplier').removeClass('d-none').addClass('d-block').html(error.responseJSON.supplier[0]);
                    }
                    if (error.responseJSON && error.responseJSON.alamat) {
                        $('#alert-alamat').removeClass('d-none').addClass('d-block').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });

        // Trigger Show Modal Edit Data
        $('body').on('click', '.button_edit_supplier', function() {
            let supplier_id = $(this).data('id');

            $.ajax({
                url: `/supplier/${supplier_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#supplier_id').val(response.data.id);
                    $('#edit_supplier').val(response.data.supplier);
                    $('#edit_alamat').val(response.data.alamat);
                    $('#modal_edit_supplier').modal('show');
                }
            });
        });

        // Aksi Simpan Perubahan Data (Update)
        $('#update').click(function(e) {
            e.preventDefault();

            let supplier_id = $('#supplier_id').val();
            let supplier = $('#edit_supplier').val();
            let alamat = $('#edit_alamat').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('supplier', supplier);
            formData.append('alamat', alamat);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/supplier/${supplier_id}`,
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

                    // Menimpa value baris yang berubah tanpa reload full
                    let row = $(`#index_${response.data.id}`);
                    row.find('td').eq(1).text(response.data.supplier);
                    row.find('td').eq(2).text(response.data.alamat);

                    $('#modal_edit_supplier').modal('hide');
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.supplier) {
                        $('#alert-supplier').removeClass('d-none').addClass('d-block').html(error.responseJSON.supplier[0]);
                    }
                    if (error.responseJSON && error.responseJSON.alamat) {
                        $('#alert-alamat').removeClass('d-none').addClass('d-block').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });

        // Aksi Hapus Data Supplier
        $('body').on('click', '.button_hapus_supplier', function() {
            let supplier_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data supplier ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669', /* Diubah ke Emerald */
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/supplier/${supplier_id}`,
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
                            
                            // Refresh interface tabel data
                            loadDataSupplier();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection