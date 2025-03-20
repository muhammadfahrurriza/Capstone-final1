<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReimburseResource\Pages;
use App\Filament\Resources\ReimburseResource\RelationManagers;
use App\Models\Reimburse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;



class ReimburseResource extends Resource
{
    protected static ?string $model = Reimburse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('users', 'name'),
                // Select::make('id_bbm')
                //     ->relationship('bbm', 'tgl_pengisian'),
                // Select::make('id_souvenir')
                //     ->relationship('souvenir', 'nama'),
                Radio::make('jenis_reimburse')
                ->options([
                    'bbm' => 'BBM',
                    'souvenir' => 'Souvenir',
                ])
                ->reactive(),

                // Fields for Option 1
                Section::make('BBM')
                ->schema([
                    Group::make()->relationship('bbm')
                    ->schema([
                        // Hidden::make('bbm.id'),
                        DateTimePicker::make('tgl_pengisian'),
                        TextInput::make('jenis_bbm'),
                        TextInput::make('jml_liter')->numeric()->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $set('total_harga',$get('harga') ? $state * $get('harga'):0);
                        }),
                        TextInput::make('harga')->numeric()->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            // if ($get('total_harga') || $get('jml_liter')) {
                            //     // $set('jml_liter', $state * $get('total_harga'));
                            // }
                            if ($get('jml_liter') > 0) {
                                $set('total_harga', $state * $get('jml_liter'));
                            }
                            elseif ($get('total_harga') > 0) {
                                $set('jml_liter', $get('total_harga') / $state ?:1);
                            }
                            
                        }),
                        TextInput::make('total_harga')->numeric()->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $set('jml_liter', $get('harga') ? $state / $get('harga') : 0);
                        }),
                    ]),
                ])
                ->hidden(fn (callable $get) => $get('jenis_reimburse') !== 'bbm'),

                // Fields for Option 2
                Section::make('Souvenir')
                ->schema([
                    Repeater::make('souvenir')
                    ->relationship('souvenir')
                    ->schema([
                        // Hidden::make('souvenir.id'),
                        TextInput::make('nama'),
                        TextInput::make('jenis'),
                        TextInput::make('merk'),
                        TextInput::make('stok')->numeric()->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $set('total_harga', $state * $get('harga'));
                        }),
                        TextInput::make('harga')->numeric()->reactive()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            $set('total_harga', $state * $get('stok'));
                        }),
                        TextInput::make('total_harga')->numeric(),
                    ]),
                ])
                ->hidden(fn (callable $get) => $get('jenis_reimburse') !== 'souvenir'),
                // DateTimePicker::make('tgl_pengajuan'),
                Hidden::make('tgl_pengajuan'),
                TextInput::make('biaya')->numeric()->label('Total Biaya')
                ->placeholder(function (Forms\Set $set, Forms\Get $get){
                    $totalsouvenir = collect($get('souvenir'))->pluck('total_harga')->sum();
                    $totalbbm = $get('bbm.total_harga');
                    $reimburse = $get('jenis_reimburse');
                    if($totalsouvenir && $reimburse === 'souvenir'){
                        $set('biaya', $totalsouvenir);
                    }
                    elseif($totalbbm && $reimburse === 'bbm'){
                        $set('biaya', $totalbbm);
                    }
                    else{$set('biaya', 0);}
                }),
                FileUpload::make('foto_bukti')
                            ->label('Foto Bukti')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('bukti_reimburse')
                            ->visibility('public'),
                Select::make('status')
                ->reactive()
                ->options([
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                ])
                ->hidden(fn () => !Auth::user()->hasRole('Bagian Keuangan')),
                DateTimePicker::make('tgl_diterima')
                ->readonly()
                ->formatstateusing(fn ($state) => $state ?? now()->format('Y-m-d H:i:s'))
                ->hidden(fn (callable $get) => $get('status') !== 'diterima'),
                DateTimePicker::make('tgl_ditolak')
                ->readonly()
                ->formatstateusing(fn ($state) => $state ?? now()->format('Y-m-d H:i:s'))
                ->hidden(fn (callable $get) => $get('status') !== 'ditolak'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->recordUrl(null)
            ->columns([
                TextColumn::make('users.name'),
                TextColumn::make('jenis_reimburse'),
                TextColumn::make('tgl_pengajuan'),
                TextColumn::make('status')
                ->badge()
                ->icon(fn ($state): string => match ($state){
                    'diterima' => 'heroicon-o-check-circle',
                    'ditolak' => 'heroicon-o-x-circle',
                    default => 'heroicon-o-x-question-mark-circle',
                })
                ->color(fn ($state): string => match ($state){
                    'diterima' => 'success',
                    'ditolak' => 'danger',
                    default => 'gray',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hidden(fn () => !Auth::user()->hasAnyRole(['Bagian Keuangan', 'Petugas'])),
                Tables\Actions\Action::make('Laporan')
                    ->url(fn($record)=>self::getUrl("laporan", ['record' => $record->id]))
                    ->hidden(fn($record) => $record->status !== "diterima"),
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
            'index' => Pages\ListReimburses::route('/'),
            'create' => Pages\CreateReimburse::route('/create'),
            'edit' => Pages\EditReimburse::route('/{record}/edit'),
            'laporan' => Pages\LaporanReimburse::route('/{record}/laporan'),
        ];
    }
}
