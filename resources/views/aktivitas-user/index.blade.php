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

    /* Global Section Text */
    .section-header h1 {
        color: var(--sage-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
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

    /* Custom Badges untuk Log Data */
    .badge-log {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 5px 10px !important;
        border-radius: 8px !important;
        letter-spacing: 0.3px;
    }

    .badge-key {
        background-color: rgba(96, 121, 100, 0.1) !important;
        color: var(--sage-main) !important;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
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
    <h1>Aktivitas User</h1>
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
                                <th scope="col" width="15%">User</th>
                                <th scope="col" width="25%">Before</th>
                                <th scope="col" width="25%">After</th>
                                <th scope="col" width="15%">Description</th>
                                <th scope="col" width="15%">Log At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                                <td>
                                    <span class="font-weight-bold text-muted" style="font-size: 13px;">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 14px; font-weight: 600; color: var(--sage-dark);">
                                        {{ $log->causer !== null ? $log->causer->name : 'System' }}
                                    </span>
                                </td>
                                <td style="font-size: 13px; line-height: 1.6;">
                                    @if (isset($log->changes['old']))
                                        @foreach ($log->changes['old'] as $key => $itemChange)
                                            <span class="badge-key">{{ $key }}</span> : <span class="text-danger">{{ $itemChange }}</span> <br>
                                        @endforeach
                                    @else
                                        <span class="text-muted italic" style="font-style: italic;">- Tidak ada perubahan -</span>
                                    @endif
                                </td>
                                <td style="font-size: 13px; line-height: 1.6;">
                                    @if (isset($log->changes['attributes']))
                                        @foreach ($log->changes['attributes'] as $key => $itemChange)
                                            <span class="badge-key">{{ $key }}</span> : <span class="text-success">{{ $itemChange }}</span> <br>
                                        @endforeach
                                    @else
                                        <span class="text-muted italic" style="font-style: italic;">- Tidak ada perubahan -</span>
                                    @endif
                                </td>
                                <td>
                                    @if(str_contains(strtolower($log->description), 'created'))
                                        <span class="badge badge-success badge-log">Created</span>
                                    @elseif(str_contains(strtolower($log->description), 'updated'))
                                        <span class="badge badge-warning badge-log">Updated</span>
                                    @elseif(str_contains(strtolower($log->description), 'deleted'))
                                        <span class="badge badge-danger badge-log">Deleted</span>
                                    @else
                                        <span class="badge badge-secondary badge-log">{{ ucfirst($log->description) }}</span>
                                    @endif
                                </td>
                                <td style="font-size: 13px; font-weight: 500; color: #6c757d;">
                                    <i class="far fa-clock mr-1" style="font-size: 11px;"></i> {{ $log->created_at->format('d-m-Y H:i:s') }}
                                </td>
                            </tr>
                            @endforeach                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery Initialization -->
<script>
    $(document).ready(function() {
        $('#table_id').DataTable({
            paging: true,
            order: [[5, "desc"]], // Otomatis mengurutkan log dari yang terbaru berdasarkan kolom 'Log At'
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari riwayat aktivitas...",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });
    });
</script>
@endsection