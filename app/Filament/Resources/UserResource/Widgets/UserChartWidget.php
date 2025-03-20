<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;


class UserChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Rasio Jumlah Role';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // $rolesData = Role::withCount('users')->get()->pluck('users_count', 'name')->toArray();
        $rolesData = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('COUNT(model_has_roles.model_id) as total'))
            ->groupBy('roles.name')
            ->pluck('total', 'name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => array_values($rolesData),
                    'backgroundColor' => [
                        'rgb(0, 95, 115)',    // Biru Tua
                        'rgb(10, 147, 150)',  // Biru Kehijauan
                        'rgb(148, 210, 189)', // Hijau Muda
                        'rgb(233, 216, 166)', // Krem / Beige
                        'rgb(238, 155, 0)',   // Jingga Kuning
                        // 'rgb(202, 103, 2)',   // Coklat Terang
                        'rgb(187, 62, 3)',    // Merah Bata
                        'rgb(174, 32, 18)'    // Merah Gelap
                    ],


                ],
            ],
            'labels' => array_keys($rolesData),
            // 'labels' => ['Admin', 'Kadin', 'Sekdin', 'Petugas', 'Keuangan', 'Pemohon', 'Peserta'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
