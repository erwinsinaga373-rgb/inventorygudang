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
        // === ROLES ===
        // Handle old role names (pre-fix) and new names
        $roles = [
            ['role' => 'owner',         'old_role' => 'superadmin',   'deskripsi' => 'Owner / Superadmin memiliki kendali penuh pada aplikasi termasuk manajemen User'],
            ['role' => 'kepala gudang', 'old_role' => 'staff gudang', 'deskripsi' => 'Kepala gudang memilki akses untuk mengelola dan mencetak laporan stok, barang masuk, dan barang keluar'],
            ['role' => 'admin',         'old_role' => 'admin gudang', 'deskripsi' => 'Admin gudang memilki akses untuk mengelola stok, barang masuk, barang keluar dan laporannya'],
        ];

        foreach ($roles as $r) {
            $role = Role::where('role', $r['old_role'])->first();
            if ($role) {
                $role->update(['role' => $r['role'], 'deskripsi' => $r['deskripsi']]);
            } else {
                Role::firstOrCreate(['role' => $r['role']], ['deskripsi' => $r['deskripsi']]);
            }
        }

        // === USERS ===
        $users = [
            ['name' => 'Owner',         'email' => 'owner@gmail.com',       'role_id' => Role::where('role', 'owner')->value('id')],
            ['name' => 'Kepala Gudang', 'email' => 'kepalagudang@gmail.com', 'role_id' => Role::where('role', 'kepala gudang')->value('id')],
            ['name' => 'Admin Gudang',  'email' => 'admin@gmail.com',        'role_id' => Role::where('role', 'admin')->value('id')],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(['email' => $u['email']], [
                'name'     => $u['name'],
                'password' => bcrypt('1234'),
                'role_id'  => $u['role_id'],
            ]);
        }

        // === JENIS ===
        Jenis::firstOrCreate(['jenis_barang' => 'pupuk cair'], ['user_id' => 1]);
        Jenis::firstOrCreate(['jenis_barang' => 'pupuk Kimia'], ['user_id' => 1]);

        // === SATUAN ===
        Satuan::firstOrCreate(['satuan' => 'Kwintal'], ['user_id' => 1]);
        Satuan::firstOrCreate(['satuan' => 'Liter'], ['user_id' => 1]);

        // === SUPPLIER ===
        Supplier::firstOrCreate(['supplier' => 'PT Petrokimia Gresik'], [
            'alamat'  => 'Gresik, Jawa Timur',
            'user_id' => 1
        ]);
        Supplier::firstOrCreate(['supplier' => 'PT Pupuk Indonesia'], [
            'alamat'  => 'Jakarta',
            'user_id' => 1
        ]);

        // === CUSTOMER ===
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
