<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BBMResource\Pages;
use App\Filament\Resources\BBMResource\RelationManagers;
use App\Models\Bbm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class BBMResource extends Resource
{
    protected static ?string $model = Bbm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('tgl_pengisian'),
                TextInput::make('jml_liter')->numeric(),
                TextInput::make('harga')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tgl_pengisian'),
                TextColumn::make('jml_liter'),
                TextColumn::make('harga'),
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
            'index' => Pages\ListBBMS::route('/'),
            'create' => Pages\CreateBBM::route('/create'),
            'edit' => Pages\EditBBM::route('/{record}/edit'),
        ];
    }
}
