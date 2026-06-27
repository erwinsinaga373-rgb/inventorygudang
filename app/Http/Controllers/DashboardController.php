<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangCount        = Barang::count();
        $barangMasukCount   = BarangMasuk::count();
        $barangKeluarCount  = BarangKeluar::count();
        $userCount          = User::count();

        // KODE GRAFIK ASLI MILIK ANDA (TIDAK DIUBAH SAMA SEKALI)
        $barangMasukData = BarangMasuk::selectRaw('DATE(tanggal_masuk) as date, SUM(jumlah_masuk) as total')
            ->groupBy('date')
            ->get();

        $barangKeluarData = BarangKeluar::selectRaw('DATE(tanggal_keluar) as date, SUM(jumlah_keluar) as total')
            ->groupBy('date')
            ->get();

        // 1. QUERY STOK MINIMUM (BAWAAN ANDA)
        $barangMinimum = Barang::whereColumn('stok', '<=', 'stok_minimum')->get();
                                        
        // 2. QUERY TAMBAHAN BARU: Membandingkan kolom 'stok' yang LEBIH BESAR dari kolom 'stok_maksimum'
        $barangMaksimum = Barang::whereColumn('stok', '>', 'stok_maksimum')->get();

        return view('dashboard', [
            'barang'            => $barangCount,
            'barangMasuk'       => $barangMasukCount,
            'barangKeluar'      => $barangKeluarCount,
            'user'              => $userCount,
            'barangMasukData'   => $barangMasukData,
            'barangKeluarData'  => $barangKeluarData,
            'barangMinimum'     => $barangMinimum,
            'barangMaksimum'    => $barangMaksimum // <-- Mengirim data barang overstock ke view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}