<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Filament\Resources\CountryResource\RelationManagers\StatesRelationManager;
use App\Models\Country;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationGroup = 'shop';

    protected static ?string $navigationIcon = 'heroicon-o-globe';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name_official')
                    ->label('Official Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cca2')
                    ->label('CCA2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cca3')
                    ->label('CCA3')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('flag')
                    ->required()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flag'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_official')
                    ->label('Official Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cca2')
                    ->label('Code')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('activate')
                    ->label(fn(Model $record) => $record->is_active ? 'Decativate' : 'Activate')
                    ->icon(fn(Model $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn(Model $record) => $record->is_active ? 'danger' : 'success')
                    ->action(fn(Model $record) => $record->update([
                        'is_active' => !$record->is_active,
                    ])),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('Deactivate Selected')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn($records) => $records->each(fn($record) => $record->update([
                        'is_active' => false,
                    ]))),
                BulkAction::make('Activate Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn($records) => $records->each(fn($record) => $record->update([
                        'is_active' => true,
                    ]))),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            // 'create' => Pages\CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            // 'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
