<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\JamKerja;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JamKerjaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JamKerjaResource\RelationManagers;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DateTimePicker;

class JamKerjaResource extends Resource
{
    protected static ?string $model = JamKerja::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->user()->can('jamkerja')) {
            return true;
        } else {
            return false;
        }
        // return Auth::check() && Auth::user()->can('jamkerja');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tgl')->required(),
                DateTimePicker::make('jam_mulai')->required(),
                DateTimePicker::make('jam_akhir')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tgl')->dateTime(),
                TextColumn::make('jam_mulai')->dateTime(),
                TextColumn::make('jam_akhir')->dateTime(),
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
            'index' => Pages\ListJamKerjas::route('/'),
            'create' => Pages\CreateJamKerja::route('/create'),
            'edit' => Pages\EditJamKerja::route('/{record}/edit'),
        ];
    }
}
