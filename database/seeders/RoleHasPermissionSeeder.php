<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rolePermissions = [
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 1, 'role_id' => 2],
            ['permission_id' => 1, 'role_id' => 3],
            ['permission_id' => 1, 'role_id' => 4],
            ['permission_id' => 1, 'role_id' => 5],
        ];

        DB::table('role_has_permissions')->insertOrIgnore($rolePermissions);
    }
}
