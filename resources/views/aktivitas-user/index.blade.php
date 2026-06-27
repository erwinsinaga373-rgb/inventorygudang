@extends('layouts.app')

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

    /* Global Section Text */
    .section-header h1 {
        color: var(--corp-dark) !important;
        font-weight: 800;
        letter-spacing: -0.75px;
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

    /* Custom Badges untuk Log Data */
    .badge-log {
        font-size: 11px !important;
        font-weight: 700 !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        letter-spacing: 0.3px;
    }

    .badge-key {
        background-color: rgba(5, 150, 105, 0.1) !important;
        color: var(--corp-green) !important;
        padding: 3px 7px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Customisasi Tampilan Sampingan DataTables */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--corp-gradient-1) !important;
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
                                    <span style="font-size: 14px; font-weight: 600; color: var(--corp-dark);">
                                        {{ $log->causer !== null ? $log->causer->name : 'System' }}
                                    </span>
                                </td>
                                <td style="font-size: 13px; line-height: 1.7;">
                                    @if (isset($log->changes['old']))
                                        @foreach ($log->changes['old'] as $key => $itemChange)
                                            <span class="badge-key">{{ $key }}</span> : <span class="text-danger font-weight-600">{{ $itemChange }}</span> <br>
                                        @endforeach
                                    @else
                                        <span class="text-muted" style="font-style: italic; font-size: 12px;">- Tidak ada perubahan -</span>
                                    @endif
                                </td>
                                <td style="font-size: 13px; line-height: 1.7;">
                                    @if (isset($log->changes['attributes']))
                                        @foreach ($log->changes['attributes'] as $key => $itemChange)
                                            <span class="badge-key">{{ $key }}</span> : <span class="text-success font-weight-600">{{ $itemChange }}</span> <br>
                                        @endforeach
                                    @else
                                        <span class="text-muted" style="font-style: italic; font-size: 12px;">- Tidak ada perubahan -</span>
                                    @endif
                                </td>
                                <td>
                                    @if(str_contains(strtolower($log->description), 'created'))
                                        <span class="badge badge-success badge-log" style="background-color: #10B981 !important; color: white;">Created</span>
                                    @elseif(str_contains(strtolower($log->description), 'updated'))
                                        <span class="badge badge-warning badge-log" style="background-color: #F59E0B !important; color: white;">Updated</span>
                                    @elseif(str_contains(strtolower($log->description), 'deleted'))
                                        <span class="badge badge-danger badge-log" style="background-color: #EF4444 !important; color: white;">Deleted</span>
                                    @else
                                        <span class="badge badge-secondary badge-log" style="background-color: #6B7280 !important; color: white;">{{ ucfirst($log->description) }}</span>
                                    @endif
                                </td>
                                <td style="font-size: 13px; font-weight: 500; color: #6B7280;">
                                    <i class="far fa-clock mr-1" style="font-size: 11px; color: var(--corp-green);"></i> {{ $log->created_at->format('d-m-Y H:i:s') }}
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