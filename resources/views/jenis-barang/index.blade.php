@extends('layouts.app')

@include('jenis-barang.create')
@include('jenis-barang.edit')

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
    
    .btn-action-edit { background-color: rgba(255, 193, 7, 0.1) !important; color: #ffc107 !important; }
    .btn-action-edit:hover { background-color: #ffc107 !important; color: #fff !important; }

    .btn-action-delete { background-color: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; }
    .btn-action-delete:hover { background-color: #dc3545 !important; color: #fff !important; }

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #738B73 0%, #4A5D4E 100%) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px;
    }
</style>

<div class="section-header mb-4">
    <h1>Data Jenis Barang</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-sage d-flex align-items-center" id="button_tambah_jenis_barang">
            <i class="fa fa-plus mr-2"></i> Tambah Jenis Barang
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="table_jenis_barang" class="table table-modern display">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">No</th>
                                <th scope="col">Jenis Barang</th>
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

<!-- Datatables Jquery & Ajax Logic -->
<script>
    $(document).ready(function() {
        $('#table_jenis_barang').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari jenis...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        function generateRowHtml(counter, value) {
            return `
                <tr class="barang-row" id="index_jenis_${value.id}">
                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                    <td style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.jenis_barang}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-edit button_edit_jenis_barang" title="Ubah"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-delete button_hapus_jenis_barang" title="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        }

        function loadDataJenis() {
            $.ajax({
                url: "/jenis-barang/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_jenis_barang').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let rowHtml = generateRowHtml(counter++, value);
                        $('#table_jenis_barang').DataTable().row.add($(rowHtml)).draw(false);
                    });
                }
            });
        }

        loadDataJenis();

        // Trigger Modal Tambah
        $('body').on('click', '#button_tambah_jenis_barang', function() {
            $('#modal_tambah_jenis_barang').modal('show');
        });

        // Simpan Data Baru
        $('#store_jenis').click(function(e) {
            e.preventDefault();

            let jenis_barang = $('#jenis_barang').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('jenis_barang', jenis_barang);
            formData.append('_token', token);

            $.ajax({
                url: '/jenis-barang',
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

                    $('#jenis_barang').val('');
                    $('#modal_tambah_jenis_barang').modal('hide');
                    loadDataJenis();
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.jenis_barang) {
                        $('#alert-jenis_barang').removeClass('d-none').addClass('d-block').html(error.responseJSON.jenis_barang[0]);
                    }
                }
            });
        });

        // Trigger Edit Data
        $('body').on('click', '.button_edit_jenis_barang', function() {
            let jenis_id = $(this).data('id');

            $.ajax({
                url: `/jenis-barang/${jenis_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#jenis_id').val(response.data.id);
                    $('#edit_jenis_barang').val(response.data.jenis_barang);
                    $('#modal_edit_jenis_barang').modal('show');
                }
            });
        });

        // Simpan Pembaruan Data
        $('#update_jenis').click(function(e) {
            e.preventDefault();

            let jenis_id = $('#jenis_id').val();
            let jenis_barang = $('#edit_jenis_barang').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('jenis_barang', jenis_barang);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/jenis-barang/${jenis_id}`,
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

                    let row = $(`#index_jenis_${response.data.id}`);
                    row.find('td').eq(1).text(response.data.jenis_barang);

                    $('#modal_edit_jenis_barang').modal('hide');
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.jenis_barang) {
                        $('#alert-jenis_barang').removeClass('d-none').addClass('d-block').html(error.responseJSON.jenis_barang[0]);
                    }
                }
            });
        });

        // Proses Hapus Data
        $('body').on('click', '.button_hapus_jenis_barang', function() {
            let jenis_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data jenis barang ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4A5D4E',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/jenis-barang/${jenis_id}`,
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
                            loadDataJenis();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection