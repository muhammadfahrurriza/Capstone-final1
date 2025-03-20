<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengajuan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PengajuanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengajuanResource\RelationManagers;

class PengajuanResource extends Resource
{
    protected static ?string $model = Pengajuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_surat')
                    ->relationship('surat', 'nomor_surat') 
                    ->required(),
                TextInput::make('id_surat')
                    // ->relationship('surat', 'nama_kegiatan') 
                    ->required(),
                TextInput::make('id_surat')
                    // ->relationship('surat', 'nama_PJ') 
                    ->required(),
                TextInput::make('id_surat')
                    // ->relationship('surat', 'jabatan_PJ') 
                    ->required(),
                TextInput::make('id_surat')
                    // ->relationship('surat', 'TTD_PJ') 
                    ->required(),
                TextInput::make('id_surat')
                    // ->relationship('surat', 'narahubung') 
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('surat.nomor_surat')->label('Nomor Surat'),
                TextColumn::make('surat.nama_kegiatan')->label('Nama Kegiatan'),
                TextColumn::make('surat.nama_PJ')->label('Nama PJ'),
                TextColumn::make('surat.jabatan_PJ')->label('Jabatan PJ'),
                TextColumn::make('surat.TTD_PJ')->label('TTD PJ'),
                TextColumn::make('surat.narahubung')->label('Narahubung'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPengajuans::route('/'),
            'create' => Pages\CreatePengajuan::route('/create'),
            'edit' => Pages\EditPengajuan::route('/{record}/edit'),
        ];
    }
}
