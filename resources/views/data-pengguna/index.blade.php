@extends('layouts.app')

@include('data-pengguna.create')
@include('data-pengguna.edit')

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
        box-shadow: 0 4px 15px rgba(74, 93, 78, 0.15) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-sage:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 93, 78, 0.25) !important;
        color: #ffffff !important;
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

    /* Action Buttons Inside Table */
    .btn-action-edit {
        background-color: #FDF8E2 !important;
        color: #D9A700 !important;
        border-radius: 10px !important;
        padding: 8px 12px !important;
        border: none !important;
        transition: all 0.2s !important;
    }

    .btn-action-edit:hover {
        background-color: #D9A700 !important;
        color: #ffffff !important;
    }

    .btn-action-delete {
        background-color: #FCECEE !important;
        color: #E04B59 !important;
        border-radius: 10px !important;
        padding: 8px 12px !important;
        border: none !important;
        transition: all 0.2s !important;
    }

    .btn-action-delete:hover {
        background-color: #E04B59 !important;
        color: #ffffff !important;
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
    <h1>Data Pengguna</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-sage d-flex align-items-center" id="button_tambah_pengguna">
            <i class="fa fa-plus mr-2"></i> Tambah Pengguna
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
                                <th scope="col" width="30%">Nama</th>
                                <th scope="col" width="30%">Email</th>
                                <th scope="col" width="15%">Role</th>
                                <th scope="col" width="20%">Opsi</th>
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
        // Inisialisasi Awal DataTables Premium
        var table = $('#table_id').DataTable({
            paging: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data pengguna...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Load Data Pertama Kali saat Halaman Dibuka
        $.ajax({
            url: "/data-pengguna/get-data",
            type: "GET",
            dataType: 'JSON',
            success: function(response) {
                let counter = 1;
                table.clear().draw();
                
                $.each(response.data, function(key, value) {
                    let pengguna = `
                    <tr class="pengguna-row" id="index_${value.id}">
                        <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span></td>
                        <td><span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.name}</span></td>
                        <td><span style="font-size: 13px; color: #6c757d; font-weight: 500;">${value.email}</span></td>
                        <td><span class="badge px-3 py-2" style="border-radius: 8px; font-weight: 700; background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark);">${value.role.role}</span></td>
                        <td>
                            <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-action-edit mr-1"><i class="far fa-edit"></i></a>
                            <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-action-delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    `;
                    table.row.add($(pengguna)).draw(false);
                });
            }
        });
    });
</script>

<!-- Show Modal Tambah Pengguna -->
<script>
    $('body').on('click', '#button_tambah_pengguna', function() {
        $('#modal_tambah_pengguna').modal('show');
    });

    $('#store').click(function(e) {
        e.preventDefault();

        let name = $('#name').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let role_id = $('#role_id').val();
        let token = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('role_id', role_id);
        formData.append('_token', token);

        $.ajax({
            url: '/data-pengguna',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });

                $.ajax({
                    url: '/data-pengguna/get-data',
                    type: "GET",
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        
                        $.each(response.data, function(key, value) {
                            getRoleName(value.role_id, function(role) {
                                let pengguna = `
                                <tr class="pengguna-row" id="index_${value.id}">
                                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span></td>
                                    <td><span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.name}</span></td>
                                    <td><span style="font-size: 13px; color: #6c757d; font-weight: 500;">${value.email}</span></td>
                                    <td><span class="badge px-3 py-2" style="border-radius: 8px; font-weight: 700; background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark);">${role}</span></td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-action-edit mr-1"><i class="far fa-edit"></i></a>
                                        <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-action-delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                `;
                                $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                            });
                        });

                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#role_id').val('');
                        $('#modal_tambah_pengguna').modal('hide');

                        function getRoleName(roleId, callback) {
                            $.getJSON('{{ url("api/role") }}', function(roles) {
                                var role = roles.find(function(s) {
                                    return s.id === roleId;
                                });
                                callback(role ? role.role : '');
                            });
                        }
                    }
                });
            },
            error: function(error) {
                if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                    $('#alert-name').removeClass('d-none').addClass('d-block').html(error.responseJSON.name[0]);
                }
                if (error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]) {
                    $('#alert-email').removeClass('d-none').addClass('d-block').html(error.responseJSON.email[0]);
                }
                if (error.responseJSON && error.responseJSON.password && error.responseJSON.password[0]) {
                    $('#alert-password').removeClass('d-none').addClass('d-block').html(error.responseJSON.password[0]);
                }
                if (error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[0]) {
                    $('#alert-role_id').removeClass('d-none').addClass('d-block').html(error.responseJSON.role_id[0]);
                }
            }
        });
    });
</script>

<!-- Edit Data Pengguna -->
<script>
    $('body').on('click', '#button_edit_pengguna', function() {
        let pengguna_id = $(this).data('id');

        $.ajax({
            url: `/data-pengguna/${pengguna_id}/edit`,
            type: "GET",
            cache: false,
            success: function(response) {
                $('#pengguna_id').val(response.data.id);
                $('#edit_name').val(response.data.name);
                $('#edit_email').val(response.data.email);
                $('#edit_password').val(response.data.password);
                $('#edit_role_id').val(response.data.role_id);
                $('#modal_edit_pengguna').modal('show');
            }
        });
    });

    $('#update').click(function(e) {
        e.preventDefault();

        let pengguna_id = $('#pengguna_id').val();
        let name = $('#edit_name').val();
        let email = $('#edit_email').val();
        let password = $('#edit_password').val();
        let role_id = $('#edit_role_id').val();
        let token = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('role_id', role_id);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        if (password !== '') {
            formData.append('password', password);
        }

        $.ajax({
            url: `/data-pengguna/${pengguna_id}`,
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });

                $.ajax({
                    url: '/data-pengguna/get-data',
                    type: "GET",
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        
                        $.each(response.data, function(key, value) {
                            getRoleName(value.role_id, function(role) {
                                let pengguna = `
                                <tr class="pengguna-row" id="index_${value.id}">
                                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span></td>
                                    <td><span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.name}</span></td>
                                    <td><span style="font-size: 13px; color: #6c757d; font-weight: 500;">${value.email}</span></td>
                                    <td><span class="badge px-3 py-2" style="border-radius: 8px; font-weight: 700; background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark);">${role}</span></td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-action-edit mr-1"><i class="far fa-edit"></i></a>
                                        <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-action-delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                `;
                                $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                            });
                        });

                        $('#modal_edit_pengguna').modal('hide');

                        function getRoleName(roleId, callback) {
                            $.getJSON('{{ url("api/role") }}', function(roles) {
                                var role = roles.find(function(s) {
                                    return s.id === roleId;
                                });
                                callback(role ? role.role : '');
                            });
                        }
                    }
                });
            },
            error: function(error) {
                if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                    $('#alert-name').removeClass('d-none').addClass('d-block').html(error.responseJSON.name[0]);
                }
                if (error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]) {
                    $('#alert-email').removeClass('d-none').addClass('d-block').html(error.responseJSON.email[0]);
                }
                if (error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[0]) {
                    $('#alert-role_id').removeClass('d-none').addClass('d-block').html(error.responseJSON.role_id[0]);
                }
            }
        });
    });
</script>

<!-- Hapus Data Pengguna -->
<script>
    $('body').on('click', '#button_hapus_pengguna', function() {
        let pengguna_id = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            style: 'border-radius: 16px;',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/data-pengguna/${pengguna_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        
                        $(`#index_${pengguna_id}`).remove();

                        $.ajax({
                            url: "/data-pengguna/get-data",
                            type: "GET",
                            dataType: 'JSON',
                            success: function(response) {
                                let counter = 1;
                                $('#table_id').DataTable().clear();
                                
                                $.each(response.data, function(key, value) {
                                    getRoleName(value.role_id, function(role) {
                                        let pengguna = `
                                        <tr class="pengguna-row" id="index_${value.id}">
                                            <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter++}</span></td>
                                            <td><span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">${value.name}</span></td>
                                            <td><span style="font-size: 13px; color: #6c757d; font-weight: 500;">${value.email}</span></td>
                                            <td><span class="badge px-3 py-2" style="border-radius: 8px; font-weight: 700; background-color: rgba(96, 121, 100, 0.15); color: var(--sage-dark);">${role}</span></td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_pengguna" data-id="${value.id}" class="btn btn-action-edit mr-1"><i class="far fa-edit"></i></a>
                                                <a href="javascript:void(0)" id="button_hapus_pengguna" data-id="${value.id}" class="btn btn-action-delete"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        `;
                                        $('#table_id').DataTable().row.add($(pengguna)).draw(false);
                                    });
                                });

                                function getRoleName(roleId, callback) {
                                    $.getJSON('{{ url("api/role") }}', function(roles) {
                                        var role = roles.find(function(s) {
                                            return s.id === roleId;
                                        });
                                        callback(role ? role.role : '');
                                    });
                                }
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endsection