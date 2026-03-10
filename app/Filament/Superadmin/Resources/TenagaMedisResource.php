<?php

namespace App\Filament\Superadmin\Resources;

use App\Filament\Superadmin\Resources\TenagaMedisResource\Pages;
use App\Models\TenagaMedis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenagaMedisResource extends Resource
{
    protected static ?string $model = TenagaMedis::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Tenaga Medis';

    protected static ?string $navigationGroup = 'Role Management Klinik';

    protected static ?string $pluralModelLabel = 'List Data Tenaga Medis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))
                    ),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->readOnly()
                    ->dehydrated()
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->label('Password')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state)),

                Forms\Components\Select::make('jenis_dokter')
                    ->label('Jenis Dokter')
                    ->options([
                                        'Umum' => 'Dokter Umum',
                                        'Gigi' => 'Dokter Gigi',
                                    ])
                     ->required(),

                Forms\Components\FileUpload::make('photo')
                    ->label('Foto Dokter')
                    ->image()
                    ->imageEditor()
                    ->directory('dokter')
                    ->disk('public')
                    ->maxSize(51200)
                    ->rules(['max:51200'])
                    ->columnSpanFull(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->height(100)
                    ->width(50),

                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_dokter')
                    ->label('Jenis Dokter')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'Umum' => 'Dokter Umum',
                        'Gigi' => 'Dokter Gigi',
                        default => $state,
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTenagaMedis::route('/'),
            'create' => Pages\CreateTenagaMedis::route('/create'),
            'edit' => Pages\EditTenagaMedis::route('/{record}/edit'),
        ];
    }
}
