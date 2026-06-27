@extends('layouts.app') @section('content')
<div class="main-content-inside py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Hasil Pencarian</h4>
            <span class="badge badge-primary">Kata Kunci: "{{ $keyword }}"</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang / Inventaris</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilCari as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge badge-success">{{ $barang->kode_barang }}</span></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>
                                    @if($barang->stok <= $barang->stok_minimum)
                                        <span class="text-danger font-weight-bold">{{ $barang->stok }} (Kritis)</span>
                                    @else
                                        {{ $barang->stok }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-box-open fa-2x mb-3 d-block"></i>
                                    Barang dengan kata kunci "<strong>{{ $keyword }}</strong>" tidak ditemukan di sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="/" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection
