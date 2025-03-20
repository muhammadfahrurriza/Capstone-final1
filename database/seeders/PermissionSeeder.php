<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['id' => 1, 'name' => 'create chats', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-05-04 19:30:59'), 'updated_at' => Carbon::parse('2025-03-04 19:30:59')],
            ['id' => 2, 'name' => 'chat', 'guard_name' => 'web', 'created_at' => Carbon::parse('2025-05-05 19:50:59'), 'updated_at' => Carbon::parse('2025-03-04 19:30:59')],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['id' => $permission['id']], $permission);
        }
    }
}
