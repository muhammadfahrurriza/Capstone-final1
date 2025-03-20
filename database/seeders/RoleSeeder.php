<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Kepala Dinas', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-04 19:31:14'), 'updated_at' => Carbon::parse('2025-03-08 23:40:26')],
            ['id' => 2, 'name' => 'Admin', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-05 20:22:01'), 'updated_at' => Carbon::parse('2025-03-05 20:22:01')],
            ['id' => 3, 'name' => 'Sekretaris Dinas', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-08 01:01:35'), 'updated_at' => Carbon::parse('2025-03-08 22:58:04')],
            ['id' => 4, 'name' => 'Petugas', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-08 01:03:08'), 'updated_at' => Carbon::parse('2025-03-08 01:03:08')],
            ['id' => 5, 'name' => 'Bagian Keuangan', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-08 01:04:05'), 'updated_at' => Carbon::parse('2025-03-08 22:57:52')],
            ['id' => 6, 'name' => 'Pemohon Kegiatan', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-08 01:07:39'), 'updated_at' => Carbon::parse('2025-03-08 22:58:17')],
            ['id' => 7, 'name' => 'Peserta Kegiatan', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-03-08 01:08:03'), 'updated_at' => Carbon::parse('2025-03-08 22:57:27')],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }
    }
}
