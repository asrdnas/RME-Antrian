<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\TenagaMedisResource\Pages;
use App\Filament\Superadmin\Resources\TenagaMedisResource\RelationManagers;
use App\Models\TenagaMedis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TenagaMedisResource extends Resource
{
    protected static ?string $model = TenagaMedis::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListTenagaMedis::route('/'),
            'create' => Pages\CreateTenagaMedis::route('/create'),
            'edit' => Pages\EditTenagaMedis::route('/{record}/edit'),
        ];
    }
}
