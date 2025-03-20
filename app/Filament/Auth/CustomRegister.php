<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;

class CustomRegister extends Register
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        Select::make('role')
                            ->label('Pilih Peran')
                            ->options([
                                'Pemohon Kegiatan' => 'Pemohon Kegiatan',
                                'Peserta Kegiatan' => 'Peserta Kegiatan',
                            ])
                            ->required(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        // Buat user dengan password terenkripsi
        $user = $this->getUserModel()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Tetapkan role yang dipilih
        if (in_array($data['role'], ['Pemohon Kegiatan', 'Peserta Kegiatan'])) {
            $user->assignRole($data['role']);
        } else {
            // Default jika tidak valid (opsional)
            $user->assignRole('Pemohon Kegiatan');
        }

        return $user;
    }
}
