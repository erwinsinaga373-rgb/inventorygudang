<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['role' => 'owner'], [
            'deskripsi' => 'Owner / Superadmin memiliki kendali penuh pada aplikasi termasuk manajemen User'
        ]);

        Role::firstOrCreate(['role' => 'kepala gudang'], [
            'deskripsi' => 'Kepala gudang memilki akses untuk mengelola dan mencetak laporan stok, barang masuk, dan barang keluar'
        ]);

        Role::firstOrCreate(['role' => 'admin'], [
            'deskripsi' => 'Admin gudang memilki akses untuk mengelola stok, barang masuk, barang keluar dan laporannya'
        ]);

        User::firstOrCreate(['email' => 'owner@gmail.com'], [
            'name'      => 'Owner',
            'password'  => bcrypt('1234'),
            'role_id'   => 1
        ]);

        User::firstOrCreate(['email' => 'kepalagudang@gmail.com'], [
            'name'      => 'Kepala Gudang',
            'password'  => bcrypt('1234'),
            'role_id'   => 2
        ]);

        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name'      => 'Admin Gudang',
            'password'  => bcrypt('1234'),
            'role_id'   => 3
        ]);

        Jenis::firstOrCreate(['jenis_barang' => 'pupuk cair'], ['user_id' => 1]);
        Jenis::firstOrCreate(['jenis_barang' => 'pupuk Kimia'], ['user_id' => 1]);

        Satuan::firstOrCreate(['satuan' => 'Kwintal'], ['user_id' => 1]);
        Satuan::firstOrCreate(['satuan' => 'Liter'], ['user_id' => 1]);

        Supplier::firstOrCreate(['supplier' => 'PT Petrokimia Gresik'], [
            'alamat'  => 'Gresik, Jawa Timur',
            'user_id' => 1
        ]);
        Supplier::firstOrCreate(['supplier' => 'PT Pupuk Indonesia'], [
            'alamat'  => 'Jakarta',
            'user_id' => 1
        ]);

        Customer::firstOrCreate(['customer' => 'CV Konco Tani'], [
            'alamat'  => 'Suronegaran, Jawa Tengah',
            'user_id' => 1
        ]);
        Customer::firstOrCreate(['customer' => 'CV Harapan Tani'], [
            'alamat'  => 'Baledono, Jawa Tengah',
            'user_id' => 1
        ]);
    }
}
