@extends('layouts.app')

@include('customer.create')
@include('customer.edit')

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
    <h1>Data Customer</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-sage d-flex align-items-center" id="button_tambah_customer">
            <i class="fa fa-plus mr-2"></i> Tambah Customer
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
                                <th scope="col" width="35%">Nama Customer</th>
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

<!-- Datatables Jquery & Ajax Logic -->
<script>
    $(document).ready(function() {
        // Inisialisasi Awal DataTable
        $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari customer...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Fungsi Blueprint Row HTML
        function generateRowHtml(counter, value) {
            return `
                <tr class="barang-row" id="index_${value.id}">
                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                    <td style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.customer}</td>
                    <td style="font-size: 13px; color: #6c757d;">${value.alamat}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-edit button_edit_customer" title="Ubah"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-delete button_hapus_customer" title="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        }

        // Fungsi Load Data Menggunakan AJAX
        function loadDataCustomer() {
            $.ajax({
                url: "/customer/get-data",
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

        // Panggil saat halaman pertama kali dimuat
        loadDataCustomer();

        // Trigger Show Modal Tambah
        $('body').on('click', '#button_tambah_customer', function() {
            $('#modal_tambah_customer').modal('show');
        });

        // Aksi Simpan Data Customer Baru
        $('#store').click(function(e) {
            e.preventDefault();

            let customer = $('#customer').val();
            let alamat = $('#alamat').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('customer', customer);
            formData.append('alamat', alamat);
            formData.append('_token', token);

            // Bersihkan error alert terdahulu
            $('#alert-customer').removeClass('d-block').addClass('d-none');
            $('#alert-alamat').removeClass('d-block').addClass('d-none');

            $.ajax({
                url: '/customer',
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
                    $('#customer').val('');
                    $('#alamat').val('');
                    $('#modal_tambah_customer').modal('hide');
                    
                    // Reload tabel data secara asinkronus
                    loadDataCustomer();
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.customer) {
                        $('#alert-customer').removeClass('d-none').addClass('d-block').html(error.responseJSON.customer[0]);
                    }
                    if (error.responseJSON && error.responseJSON.alamat) {
                        $('#alert-alamat').removeClass('d-none').addClass('d-block').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });

        // Trigger Show Modal Edit Data
        $('body').on('click', '.button_edit_customer', function() {
            let customer_id = $(this).data('id');

            $.ajax({
                url: `/customer/${customer_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#customer_id').val(response.data.id);
                    $('#edit_customer').val(response.data.customer);
                    $('#edit_alamat').val(response.data.alamat);
                    $('#modal_edit_customer').modal('show');
                }
            });
        });

        // Aksi Simpan Perubahan Data (Update)
        $('#update').click(function(e) {
            e.preventDefault();

            let customer_id = $('#customer_id').val();
            let customer = $('#edit_customer').val();
            let alamat = $('#edit_alamat').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('customer', customer);
            formData.append('alamat', alamat);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/customer/${customer_id}`,
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

                    // Update data pada baris yang bersangkutan langsung di DOM
                    let row = $(`#index_${response.data.id}`);
                    row.find('td').eq(1).text(response.data.customer);
                    row.find('td').eq(2).text(response.data.alamat);

                    $('#modal_edit_customer').modal('hide');
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.customer) {
                        $('#alert-customer').removeClass('d-none').addClass('d-block').html(error.responseJSON.customer[0]);
                    }
                    if (error.responseJSON && error.responseJSON.alamat) {
                        $('#alert-alamat').removeClass('d-none').addClass('d-block').html(error.responseJSON.alamat[0]);
                    }
                }
            });
        });

        // Aksi Hapus Data Customer
        $('body').on('click', '.button_hapus_customer', function() {
            let customer_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data customer ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4A5D4E',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/customer/${customer_id}`,
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
                            
                            // Re-render data tabel agar sinkron kembali
                            loadDataCustomer();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection