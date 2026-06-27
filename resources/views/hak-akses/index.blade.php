@extends('layouts.app')

@include('hak-akses.create')
@include('hak-akses.edit')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;        /* Emerald 900 - Teks utama & judul */
        --corp-navy: #022C22;        /* Emerald 950 - Topbar / Nav background */
        --corp-muted: #34D399;       /* Emerald 400 - Teks sekunder / batasan halus */
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

    .btn-premium-emerald {
        background: var(--corp-gradient-1) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2) !important;
        transition: all 0.3s ease !important;
    }

    .btn-premium-emerald:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35) !important;
        opacity: 0.95;
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

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--corp-border) !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        background-color: #fff !important;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none !important;
        border-color: var(--corp-green) !important;
        box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.1) !important;
    }
</style>

<div class="section-header mb-4">
    <h1>Hak Akses</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-emerald d-flex align-items-center" id="button_tambah_role">
            <i class="fa fa-user-shield mr-2"></i> Tambah Role
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
                                <th scope="col">Role</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col" width="15%" class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data dimuat dinamis melalui AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables awal dengan konfigurasi pencarian tema inventaris
        let table = $('#table_id').DataTable({
            paging: true,
            processing: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data hak akses...",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data role yang ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });

        // Helper reusable untuk menyusun HTML baris tabel
        function generateRowHtml(counter, value) {
            return `
                <tr class="role-row" id="index_${value.id}">
                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                    <td style="font-size: 14px; font-weight: 600; color: var(--corp-dark);"><i class="fas fa-id-badge mr-2 text-muted"></i>${value.role}</td>
                    <td style="font-size: 14px; color: #064E3B;">${value.deskripsi ? value.deskripsi : '<em class="text-muted">- Tidak ada deskripsi -</em>'}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-edit button_edit_role" title="Ubah"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-delete button_hapus_role" title="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        }

        // Fungsi fetch data utama agar tersinkronisasi sempurna dengan reload DataTables
        function loadDataRole() {
            $.ajax({
                url: "/hak-akses/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    table.clear();
                    $.each(response.data, function(key, value) {
                        let rowHtml = generateRowHtml(counter++, value);
                        table.row.add($(rowHtml));
                    });
                    table.draw(false);
                }
            });
        }

        // Jalankan saat pertama kali halaman terbuka
        loadDataRole();

        // Trigger Modal Tambah Data
        $('body').on('click', '#button_tambah_role', function() {
            // Reset sisa peringatan eror sebelumnya (Form Tambah)
            $('#alert-role').removeClass('d-block').addClass('d-none').html('');
            $('#alert-deskripsi').removeClass('d-block').addClass('d-none').html('');
            
            // Mengosongkan form jika ada sisa inputan sebelumnya
            $('#role').val('');
            $('#deskripsi').val('');
            
            $('#modal_tambah_role').modal('show');
        });

        // Aksi Simpan Data Baru via AJAX
        $('#store').click(function(e) {
            e.preventDefault();

            let role = $('#role').val();
            let deskripsi = $('#deskripsi').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('role', role);
            formData.append('deskripsi', deskripsi);
            formData.append('_token', token);

            $.ajax({
                url: '/hak-akses',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#ffffff',
                        confirmButtonColor: '#059669'
                    });

                    $('#modal_tambah_role').modal('hide');
                    loadDataRole();
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.role) {
                        $('#alert-role').removeClass('d-none').addClass('d-block').html(error.responseJSON.role[0]);
                    }
                    if (error.responseJSON && error.responseJSON.deskripsi) {
                        $('#alert-deskripsi').removeClass('d-none').addClass('d-block').html(error.responseJSON.deskripsi[0]);
                    }
                }
            });
        });

        // Trigger Tampil Modal Edit Data
        $('body').on('click', '.button_edit_role', function() {
            let role_id = $(this).data('id');

            // Reset sisa peringatan eror sebelumnya (Form Edit)
            $('#alert-edit-role').removeClass('d-block').addClass('d-none').html('');
            $('#alert-edit-deskripsi').removeClass('d-block').addClass('d-none').html('');

            $.ajax({
                url: `/hak-akses/${role_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#role_id').val(response.data.id);
                    $('#edit_role').val(response.data.role);
                    $('#edit_deskripsi').val(response.data.deskripsi);
                    $('#modal_edit_role').modal('show');
                }
            });
        });

        // Aksi Simpan Perubahan Data (Update)
        $('#update').click(function(e) {
            e.preventDefault();

            let role_id = $('#role_id').val();
            let role = $('#edit_role').val();
            let deskripsi = $('#edit_deskripsi').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('role', role);
            formData.append('deskripsi', deskripsi);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/hak-akses/${role_id}`,
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Diperbarui!',
                        text: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#ffffff',
                        confirmButtonColor: '#059669'
                    });

                    $('#modal_edit_role').modal('hide');
                    loadDataRole(); 
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.role) {
                        $('#alert-edit-role').removeClass('d-none').addClass('d-block').html(error.responseJSON.role[0]);
                    }
                    if (error.responseJSON && error.responseJSON.deskripsi) {
                        $('#alert-edit-deskripsi').removeClass('d-none').addClass('d-block').html(error.responseJSON.deskripsi[0]);
                    }
                }
            });
        });

        // Aksi Hapus Data dengan Konfirmasi SweetAlert2 Premium
        $('body').on('click', '.button_hapus_role', function() {
            let role_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Hak akses pengguna ini akan dihapus secara permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/hak-akses/${role_id}`,
                        type: "DELETE",
                        cache: false,
                        data: { "_token": token },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: `${response.message}`,
                                showConfirmButton: false,
                                timer: 2000,
                                background: '#ffffff',
                                confirmButtonColor: '#059669'
                            });
                            
                            loadDataRole();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection