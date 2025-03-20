<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjadwalanResource\Pages;
use App\Filament\Resources\PenjadwalanResource\RelationManagers;
use App\Models\Penjadwalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;


class PenjadwalanResource extends Resource
{
    protected static ?string $model = Penjadwalan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('users', 'name', function ($query){
                        $query->whereHas('roles', function($roleQuery){
                            $roleQuery->where('name', 'Petugas');
                        });
                    })
                    ->label('Pegawai'),
                // TextInput::make('surat_id'),
                    Select::make('surat_id')
                    ->relationship('surat', 'nomor_surat')
                    ->label('Surat'),
                Select::make('mobil_id')
                    ->relationship('mobils', 'nama')
                    ->label('Mobil'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('users.name')->label('Pegawai'),
                TextColumn::make('surat.nomor_surat'),
                TextColumn::make('mobils.nama'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjadwalans::route('/'),
            'create' => Pages\CreatePenjadwalan::route('/create'),
            'edit' => Pages\EditPenjadwalan::route('/{record}/edit'),
        ];
    }
}
