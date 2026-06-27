@extends('layouts.app')

@include('barang.create')
@include('barang.edit')
@include('barang.show')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;        /* Emerald 900 - Untuk teks utama/judul */
        --corp-navy: #022C22;        /* Emerald 950 - Untuk Topbar / Sisi aktif */
        --corp-muted: #34D399;       /* Emerald 400 - Untuk teks sekunder */
        --corp-bg-soft: #F0FDF4;     /* Emerald 50 Background utama bersih */
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

    /* Thumbnail Minimalis */
    .img-thumbnail-premium {
        width: 65px !important;
        height: 65px !important;
        object-fit: cover !important;
        border-radius: 14px !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
        transition: all 0.3s ease;
    }

    .table-modern tr:hover .img-thumbnail-premium {
        transform: scale(1.08);
        box-shadow: 0 6px 15px rgba(5, 150, 105, 0.15) !important;
    }

    /* Badge Stok (Clean & High Contrast) */
    .badge-premium-stok {
        background-color: rgba(16, 185, 129, 0.1) !important; /* Hijau Emerald Soft */
        color: #059669 !important;                               /* Teks Hijau Tegas */
        font-weight: 700;
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 12px;
    }

    .badge-premium-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;  /* Merah Soft */
        color: #DC2626 !important;                             /* Teks Merah Tegas */
        font-weight: 700;
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 12px;
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

    .btn-action-view { background-color: rgba(16, 185, 129, 0.1) !important; color: #059669 !important; }
    .btn-action-view:hover { background-color: #059669 !important; color: #fff !important; }
    
    .btn-action-edit { background-color: rgba(245, 158, 11, 0.1) !important; color: #D97706 !important; }
    .btn-action-edit:hover { background-color: #D97706 !important; color: #fff !important; }

    .btn-action-delete { background-color: rgba(239, 68, 68, 0.1) !important; color: #DC2626 !important; }
    .btn-action-delete:hover { background-color: #DC2626 !important; color: #fff !important; }

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--corp-gradient-1) !important;
        color: white !important;
        border: none !important;
        border-radius: 8px;
    }

    /* Penyesuaian Input Cari DataTables Premium */
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
    <h1>Data Barang</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-premium-corp d-flex align-items-center" id="button_tambah_barang">
            <i class="fa fa-plus mr-2"></i> Tambah Barang
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
                                <th scope="col" width="12%">Gambar</th>
                                <th scope="col" width="18%">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col" width="15%">Stok</th>
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
        // Inisialisasi awal DataTable
        let table = $('#table_id').DataTable({
            paging: true,
            language: {
                search: "",
                searchPlaceholder: "Cari produk...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });

        // Pengelompokan field input untuk manajemen error & pembersihan otomatis
        let fields = ['gambar', 'nama_barang', 'stok_minimum', 'stok_maksimum', 'jenis_id', 'satuan_id', 'deskripsi'];

        // Fungsi enkapsulasi pembuatan baris tabel internal (raw HTML)
        function generateRowHtml(counter, value) {
            let stokBadge = value.stok != null ? 
                `<span class="badge-premium-stok"><i class="fas fa-box mr-1"></i> ${value.stok}</span>` : 
                `<span class="badge-premium-danger"><i class="fas fa-times-circle mr-1"></i> Stok Kosong</span>`;
            
            return `
                <tr class="barang-row" id="index_${value.id}">
                    <td><span class="font-weight-bold text-muted" style="font-size: 13px;">${counter}</span></td>
                    <td>
                        <img src="/storage/${value.gambar}" class="img-thumbnail-premium" alt="Gambar">
                    </td>
                    <td class="font-weight-bold" style="color: var(--corp-green); font-size: 13px;">${value.kode_barang}</td>
                    <td style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">${value.nama_barang}</td>
                    <td>${stokBadge}</td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-view action-detail" title="Detail"><i class="far fa-eye"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-edit action-edit" title="Ubah"><i class="far fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="${value.id}" class="btn btn-action-premium btn-action-delete action-delete" title="Hapus"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
        }

        // Fungsi utilitas untuk memuat ulang data tabel secara bersih tanpa merusak state DataTables
        function reloadTableData() {
            $.ajax({
                url: "/barang/get-data",
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

        // FIXED: Expose fungsi render data pencarian ke lingkup global window agar dibaca Navbar AJAX
        window.updateTableWithSearchData = function(searchData) {
            let counter = 1;
            table.clear();
            $.each(searchData, function(key, value) {
                let rowHtml = generateRowHtml(counter++, value);
                table.row.add($(rowHtml));
            });
            table.draw(false);
        }

        // Fetch Pertama Kali Saat Halaman Dimuat
        reloadTableData();

        // Trigger Modal Tambah
        $('body').on('click', '#button_tambah_barang', function() {
            fields.forEach(f => $(`#alert-${f}`).addClass('d-none').html(''));
            $('#modal_tambah_barang').modal('show');
        });

        // Simpan Data Baru (Store)
        $('#store').click(function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('gambar', $('#gambar')[0].files[0]);
            formData.append('nama_barang', $('#nama_barang').val());
            formData.append('stok_minimum', $('#stok_minimum').val());
            formData.append('stok_maksimum', $('#stok_maksimum').val()); 
            formData.append('jenis_id', $('#jenis_id').val());
            formData.append('satuan_id', $('#satuan_id').val());
            formData.append('deskripsi', $('#deskripsi').val());
            formData.append('_token', $("meta[name='csrf-token']").attr("content"));

            fields.forEach(f => $(`#alert-${f}`).addClass('d-none').html(''));

            $.ajax({
                url: '/barang',
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

                    reloadTableData();

                    // Reset form fields
                    $('#gambar').val('');
                    $('#preview').attr('src', '');
                    $('#nama_barang').val('');
                    $('#stok_minimum').val('');
                    $('#stok_maksimum').val(''); 
                    $('#deskripsi').val('');
                    $('#modal_tambah_barang').modal('hide');
                },
                error: function(error) {
                    fields.forEach(function(field) {
                        if (error.responseJSON && error.responseJSON[field]) {
                            $(`#alert-${field}`).removeClass('d-none').addClass('d-block').html(error.responseJSON[field][0]);
                        }
                    });
                }
            });
        });

        // Trigger Detail Data
        $('body').on('click', '.action-detail', function() {
            let barang_id = $(this).data('id');
            $.ajax({
                url: `/barang/${barang_id}/`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#barang_id').val(response.data.id);
                    $('#detail_nama_barang').val(response.data.nama_barang);
                    $('#detail_jenis_id').val(response.data.jenis_id);
                    $('#detail_satuan_id').val(response.data.satuan_id);
                    $('#detail_stok').val(response.data.stok !== null && response.data.stok !== '' ? response.data.stok : 'Stok Kosong');
                    $('#detail_stok_minimum').val(response.data.stok_minimum);
                    $('#detail_stok_maksimum').val(response.data.stok_maksimum); 
                    $('#detail_deskripsi').val(response.data.deskripsi);
                    $('#detail_gambar_preview').attr('src', '/storage/' + response.data.gambar);
                    $('#modal_detail_barang').modal('show');
                }
            });
        });

        // Trigger Edit Data
        $('body').on('click', '.action-edit', function() {
            let barang_id = $(this).data('id');
            fields.forEach(f => $(`#alert-${f}`).addClass('d-none').html(''));

            $.ajax({
                url: `/barang/${barang_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#barang_id').val(response.data.id);
                    $('#edit_nama_barang').val(response.data.nama_barang);
                    $('#edit_stok_minimum').val(response.data.stok_minimum);
                    $('#edit_stok_maksimum').val(response.data.stok_maksimum); 
                    $('#edit_jenis_id').val(response.data.jenis_id);
                    $('#edit_satuan_id').val(response.data.satuan_id);
                    $('#edit_deskripsi').val(response.data.deskripsi);
                    $('#edit_gambar_preview').attr('src', '/storage/' + response.data.gambar);
                    $('#modal_edit_barang').modal('show');
                }
            });
        });

        // Simpan Pembaruan Data (Update)
        $('#update').click(function(e) {
            e.preventDefault();

            let barang_id = $('#barang_id').val();
            let formData = new FormData();
            formData.append('gambar', $('#edit_gambar')[0].files[0]);
            formData.append('nama_barang', $('#edit_nama_barang').val());
            formData.append('stok_minimum', $('#edit_stok_minimum').val());
            formData.append('stok_maksimum', $('#edit_stok_maksimum').val()); 
            formData.append('deskripsi', $('#edit_deskripsi').val());
            formData.append('jenis_id', $('#edit_jenis_id').val());
            formData.append('satuan_id', $('#edit_satuan_id').val());
            formData.append('_token', $("meta[name='csrf-token']").attr("content"));
            formData.append('_method', 'PUT');

            fields.forEach(f => $(`#alert-${f}`).addClass('d-none').html(''));

            $.ajax({
                url: `/barang/${barang_id}`,
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

                    let rowNode = $(`#index_${response.data.id}`);
                    let cells = rowNode.find('td');
                    
                    cells.eq(1).html(`<img src="/storage/${response.data.gambar}" class="img-thumbnail-premium" alt="Gambar">`);
                    cells.eq(2).text(response.data.kode_barang);
                    cells.eq(3).text(response.data.nama_barang);
                    
                    let updatedStokBadge = response.data.stok != null ? 
                        `<span class="badge-premium-stok"><i class="fas fa-box mr-1"></i> ${response.data.stok}</span>` : 
                        `<span class="badge-premium-danger"><i class="fas fa-times-circle mr-1"></i> Stok Kosong</span>`;
                    cells.eq(4).html(updatedStokBadge);

                    table.row(rowNode).invalidate().draw(false);

                    $('#modal_edit_barang').modal('hide');
                },
                error: function(error) {
                    fields.forEach(function(field) {
                        if (error.responseJSON && error.responseJSON[field]) {
                            $(`#alert-${field}`).removeClass('d-none').addClass('d-block').html(error.responseJSON[field][0]);
                        }
                    });
                }
            });
        });

        // Proses Hapus Data
        $('body').on('click', '.action-delete', function() {
            let barang_id = $(this).data('id');
            let rowNode = $(`#index_${barang_id}`);

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data inventaris ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#ef4444',    
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/barang/${barang_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": $("meta[name='csrf-token']").attr("content")
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            table.row(rowNode).remove().draw(false);
                        }
                    });
                }
            });
        });
    });

    // Preview Image Upload Handler
    function previewImage() {
        if(event.target.files.length > 0) {
            preview.src = URL.createObjectURL(event.target.files[0]);
        }
    }
    function previewImageEdit() {
        if(event.target.files.length > 0) {
            edit_gambar_preview.src = URL.createObjectURL(event.target.files[0]);
        }
    }
</script>
@endsection