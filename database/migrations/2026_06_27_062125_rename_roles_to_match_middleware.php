<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('roles')->where('role', 'superadmin')->update([
            'role' => 'owner',
            'deskripsi' => 'Owner / Superadmin memiliki kendali penuh pada aplikasi termasuk manajemen User'
        ]);

        DB::table('roles')->where('role', 'staff gudang')->update([
            'role' => 'kepala gudang',
            'deskripsi' => 'Kepala gudang memilki akses untuk mengelola dan mencetak laporan stok, barang masuk, dan barang keluar'
        ]);

        DB::table('roles')->where('role', 'admin gudang')->update([
            'role' => 'admin',
            'deskripsi' => 'Admin gudang memilki akses untuk mengelola stok, barang masuk, barang keluar dan laporannya'
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->where('role', 'owner')->update([
            'role' => 'superadmin',
            'deskripsi' => 'Superadmin memiliki kendali penuh pada aplikasi termasuk manajemen User'
        ]);

        DB::table('roles')->where('role', 'kepala gudang')->update([
            'role' => 'staff gudang',
            'deskripsi' => 'Kepala gudang memilki akses untuk mengelola dan mencetak laporan stok, barang masuk, dan barang keluar'
        ]);

        DB::table('roles')->where('role', 'admin')->update([
            'role' => 'admin gudang',
            'deskripsi' => 'Admin gudang memilki akses untuk mengelola stok, barang masuk, barang keluar dan laporannya'
        ]);
    }
};
