<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxResource\Pages;
use App\Filament\Resources\TaxResource\RelationManagers;
use App\Models\Tax;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class TaxResource extends Resource
{
    protected static ?string $model = Tax::class;

    protected static ?string $navigationGroup = 'shop';

    protected static ?string $navigationIcon = 'heroicon-o-receipt-tax';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('tax_group_id')
                //     ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(null)
                    ->helperText(function(callable $get, $record): ?HtmlString {
                        if (filled($get('name'))) {
                            $slug = slugify_model(Tax::class, $get('name'), $record?->slug);
                            return new HtmlString(<<<EOD
                                Slug: <strong>{$slug}</strong>
                            EOD);
                        }
                        return null;
                    }),
                Forms\Components\TextInput::make('short_name')
                    ->label('Short Display Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('calculation_type')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\TextInput::make('rate')
                    ->label('Tax Rate')
                    ->suffix('%')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('tax_group_id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                // Tables\Columns\TextColumn::make('calculation_type'),
                Tables\Columns\TextColumn::make('rate')
                    ->getStateUsing(fn($record): string => $record->rate . '%'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTaxes::route('/'),
            'create' => Pages\CreateTax::route('/create'),
            'edit' => Pages\EditTax::route('/{record}/edit'),
        ];
    }
}
