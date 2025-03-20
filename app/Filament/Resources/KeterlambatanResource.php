<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeterlambatanResource\Pages;
use App\Filament\Resources\KeterlambatanResource\RelationManagers;
use App\Models\Keterlambatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class KeterlambatanResource extends Resource
{
    protected static ?string $model = Keterlambatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kehadiran_id')
                    ->relationship('kehadiran', 'waktu_mulai', fn ($query) => $query->where('waktu_mulai_status', 'Telat')
                    ->orWhere('waktu_selesai_status', 'Telat')),
                RichEditor::make('keterangan')
                ->label('Keterangan Terlambat')
                ->columnSpanFull()
                ->disableToolbarButtons([
                    'attachFiles'
                    // 'strike',
                ]),
                FileUpload::make('foto')
                            ->label('Foto Bukti')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('foto_keterlambatan')
                            ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->recordUrl(null)
            ->columns([
                
                TextColumn::make('kehadiran.penjadwalan.surat.nama_kegiatan')->label('Nama Kegiatan'),
                TextColumn::make('keterangan')->limit(50)->label('Keterangan Terlambat'),
                ImageColumn::make('foto')->disk('public')->label('Foto Bukti'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hidden(fn () => !Auth::user()->hasRole('Petugas')),
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
            'index' => Pages\ListKeterlambatans::route('/'),
            'create' => Pages\CreateKeterlambatan::route('/create'),
            'edit' => Pages\EditKeterlambatan::route('/{record}/edit'),
        ];
    }
}
