@extends('layouts.app')

@section('content')
<style>
    :root {
        --corp-dark: #064E3B;
        --corp-border: #DCFCE7;
        --corp-gradient-1: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }
    body .navbar-bg {
        background: linear-gradient(135deg, #022C22 0%, #064E3B 100%) !important;
        height: 125px !important;
    }
    .card-premium {
        border: none !important;
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(2, 44, 34, 0.03) !important;
    }
    .form-control-premium {
        border: 2px solid var(--corp-border) !important;
        border-radius: 12px !important;
        height: 46px !important;
        font-weight: 600 !important;
        color: var(--corp-dark) !important;
        background-color: #FAFCFA !important;
    }
</style>

<div class="section-header mb-4">
    <h1>Edit Transaksi Barang Masuk</h1>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">{{ session('error') }}</div>
            </div>
        @endif
        
        <div class="card card-premium p-4">
            <div class="card-body">
                <form action="/laporan-barang-masuk/{{ $transaksi->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label class="font-weight-bold" style="color: var(--corp-dark);">Nama Barang</label>
                        <input type="text" class="form-control form-control-premium" value="{{ $transaksi->barang->nama_barang }}" readonly style="background-color: #E2E8F0 !important;">
                    </div>

                    <div class="form-group mb-3">
                        <label for="jumlah_masuk" class="font-weight-bold" style="color: var(--corp-dark);">Jumlah Masuk Baru</label>
                        <input type="number" name="jumlah_masuk" id="jumlah_masuk" class="form-control form-control-premium" value="{{ $transaksi->jumlah_masuk }}" required min="1">
                    </div>

                    <div class="form-group mb-4">
                        <label for="tanggal_masuk" class="font-weight-bold" style="color: var(--corp-dark);">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control form-control-premium" value="{{ $transaksi->tanggal_masuk }}" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="/laporan-barang-masuk" class="btn btn-secondary mr-2 font-weight-bold px-4" style="border-radius: 12px;">Batal</a>
                        <button type="submit" class="btn btn-success font-weight-bold px-4" style="background: var(--corp-gradient-1); border: none; border-radius: 12px;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection