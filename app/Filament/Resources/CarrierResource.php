<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarrierResource\Pages;
use App\Filament\Resources\CarrierResource\RelationManagers;
use App\Filament\Resources\CarrierResource\RelationManagers\PricingRelationManager;
use App\Models\Carrier;
use App\Models\Enums\ShippingRules;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Shopper\Framework\Models\System\Country;

class CarrierResource extends Resource
{
    protected static ?string $model = Carrier::class;

    protected static ?string $navigationGroup = 'shop';

    protected static ?string $modelLabel = 'Shipping';

    protected static ?string $pluralModelLabel = 'Shipping';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->lazy()
                    ->afterStateUpdated(fn(callable $set, $state, $record) => $set('slug', slugify_model(Carrier::class, $state, $record->slug))),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\TextInput::make('shipping_amount')
                    ->label('Base Charge')
                    ->prefix(shopper_currency())
                    ->required(),
                Select::make('rule_type')
                    ->required()
                    ->in(ShippingRules::values())
                    ->options(ShippingRules::toLongArray())
                    ->searchable()
                    ->helperText(fn($record): ?string =>
                        ($record?->refresh()->pricing()->count() >= 1) ?
                        new HtmlString('<span class="text-danger-700">Cannot update <strong>Rule Type</strong> when pricing rules are present. Delete <strong>Pricing Rules</strong> to Update Rule Type.</span>') :
                        null
                    )
                    ->reactive()
                    ->afterStateUpdated(null)
                    ->disabled(fn($record): bool => $record?->refresh()->pricing()->count() >= 1)
                    ->dehydrated(fn($record): bool => $record?->refresh()->pricing()->count() < 1),
                Select::make('country_id')
                    ->required()
                    ->exists('system_countries', 'id')
                    ->options(Country::pluck('name', 'id'))
                    ->searchable()
                    ->hidden(fn(callable $get) => $get('rule_type') !== ShippingRules::STATE->value)
                    ->disabled(fn($record, callable $get): bool =>
                        $record?->refresh()->pricing()->count() >= 1 OR
                        $get('rule_type') !== ShippingRules::STATE->value
                    )
                    ->dehydrated(fn($record, callable $get): bool =>
                        $record?->refresh()->pricing()->count() < 1 OR
                        $get('rule_type') !== ShippingRules::STATE->value
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_enabled')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('rule_type')
                    ->label('Rule')
                    ->getStateUsing(fn($record) => $record->rule_type->longLabel()),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('shipping_amount')
                    ->label('Base Amount'),
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
            PricingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarriers::route('/'),
            'create' => Pages\CreateCarrier::route('/create'),
            'edit' => Pages\EditCarrier::route('/{record}/edit'),
        ];
    }
}
