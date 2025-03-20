<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'a@gmail.com',
                'email' => 'a@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$aqusLYTasDq1AJxvUYGGpO/HqnDANTqoxnCXG7PHMK9pqjzRf0ILK',
                'remember_token' => 'VaTw2Ehaif1NMfyen18uoCJCref4jVWY3zKXWnGce6gM1ttPtVpE75o49kIR',
                'created_at' => '2025-02-23 01:07:26',
                'updated_at' => '2025-03-05 22:42:51',
            ],
            [
                'name' => 'kadin',
                'email' => 'kadin@e.c',
                'email_verified_at' => '2025-03-03 19:49:10',
                'password' => '$2y$12$E2CoKarU9TB9g6GaDePgzeyJ7oIyfbEGyFwu3S0yfpkNkr96yZ7La',
                'remember_token' => 'L4hI5vpqEKXTrSrlhUl4FwZZH3iHV85YSnAMMGXYk3tgySDePoMZ4LbE2Iip',
                'created_at' => '2025-03-03 19:49:11',
                'updated_at' => '2025-03-08 23:23:47',
            ],
            [
                'name' => 'Sekdin',
                'email' => 'sekdin@e.c',
                'email_verified_at' => null,
                'password' => '$2y$12$/AxBcm0d6OeUIwYXJEiiY.hU4UoBIX0igKzw9KckejAAN48MTLGY2',
                'remember_token' => 'q3kMiXRD4sClXBnHOYl1t4mA33SJg7FCKJbEbNT5QKoI8gFwK2EBavCfPrHO',
                'created_at' => '2025-03-07 00:52:55',
                'updated_at' => '2025-03-08 23:15:52',
            ],
            [
                'name' => 'Pemohon kegiatan',
                'email' => 'pemohon@e.c',
                'email_verified_at' => null,
                'password' => '$2y$12$HnYVbe.jTqjkFtRHLHX/JeLXhp6XHbUCL7iqzRUJvUgZCnH44GmUi',
                'remember_token' => null,
                'created_at' => '2025-03-07 20:16:59',
                'updated_at' => '2025-03-08 01:13:13',
            ],
            [
                'name' => 'Peserta kegiatan',
                'email' => 'peserta@e.c',
                'email_verified_at' => null,
                'password' => '$2y$12$su/o55Q.sX5ke4y49ZNr8uTynuJGXWo2nDyCCphS3.Z0vgB81XHHK',
                'remember_token' => null,
                'created_at' => '2025-03-07 20:18:12',
                'updated_at' => '2025-03-08 01:13:57',
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@e.c',
                'email_verified_at' => null,
                'password' => '$2y$12$s6BaGaNQXm7dLqIBl4F9mOI/LCr6ZLSMkvdKqSk1d.nOgpbsuEGBS',
                'remember_token' => 'bhe6j5JVaVnm0XGiCeVb6zdH5gTdiT8KK6Zj8B3Wv182YJKu3CAaPb4M4rhh',
                'created_at' => '2025-03-08 01:11:30',
                'updated_at' => '2025-03-08 01:11:30',
            ],
            [
                'name' => 'Bagian keuangan',
                'email' => 'keuangan@e.c',
                'email_verified_at' => null,
                'password' => '$2y$12$L5fQu2YA1d4WcQad47/Uf.ivXTQKSgdx6Ix426wi.DtThlUxVRhbG',
                'remember_token' => null,
                'created_at' => '2025-03-08 01:14:46',
                'updated_at' => '2025-03-08 01:14:46',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
