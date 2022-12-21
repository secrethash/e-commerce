<?php

namespace App\Filament\Resources\CarrierResource\RelationManagers;

use App\Models\Enums\CarrierCalculationMethod;
use App\Models\Enums\ShippingRules;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PricingRelationManager extends RelationManager
{
    protected static string $relationship = 'pricing';

    protected static ?string $title = 'Pricing Rules';

    protected static ?string $recordTitleAttribute = 'rule';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Calculation Method')
                    ->schema([
                        Radio::make('method')
                            ->label(null)
                            ->in(CarrierCalculationMethod::values())
                            ->options(CarrierCalculationMethod::toArray())
                            ->required()
                            ->inline()
                            ->reactive(),
                    ]),
                Group::make()
                    ->schema(function (RelationManager $livewire) {
                        $owner = $livewire->ownerRecord;
                        $rule = $owner->rule_type ?? null;
                        $calculable = $rule?->calculableType();

                        if (filled($calculable)) {
                            return [
                                Select::make('calculable_id')
                                    ->label($rule->longLabel() ?? 'Value')
                                    ->searchable()
                                    ->options( function() use($calculable, $rule, $owner) {
                                        $query = $calculable::query();
                                        $whereClause = $rule->whereClause();
                                        if ($whereClause && count($whereClause->toArray()) >= 1) {
                                            if ($owner->{$whereClause->ownerColumn}) {
                                                if (filled($whereClause->expression)) {
                                                    $query->where(
                                                        $whereClause->column,
                                                        $whereClause->expression,
                                                        $owner->{$whereClause->ownerColumn}
                                                    );
                                                } else {
                                                    $query->where(
                                                        $whereClause->column,
                                                        $owner->{$whereClause->ownerColumn}
                                                    );
                                                }
                                            }
                                        }

                                        return $query->get()->pluck(
                                            $rule->displayColumn(),
                                            $rule->keyColumn()
                                        );
                                    })
                                    ->exists((new $calculable)->getTable(), $rule->keyColumn())
                                    ->required(),
                            ];
                        }
                        return [
                            TextInput::make('calculable_value')
                                ->label($rule->longLabel() ?? 'Value')
                                ->required(),
                        ];
                    })->reactive(),
                TextInput::make('amount')
                    ->label(fn(callable $get) => 'Charge' . (filled($get('method')) ? ' in ' . CarrierCalculationMethod::from($get('method'))->identifiers() : null))
                    // ->prefix(fn(callable $get) => filled($get('method')) ? CarrierCalculationMethod::from($get('method'))->identifiers() : null)
                    ->numeric()
                    ->required(),
                Fieldset::make('Order Value')
                    ->schema([
                        TextInput::make('minimum_order')
                            ->label('Minimum Order Value')
                            ->numeric()
                            ->nullable()
                            ->required(),
                        TextInput::make('maximum_order')
                            ->label('Maximum Order Value')
                            ->numeric()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->getStateUsing(function(Model $record): string {
                        if(filled($record->calculable_type) &&
                            filled($record->calculable_id)
                        ) {
                            $displayColumn = $record->carrier->rule_type->displayColumn();
                            return $record->calculable->{$displayColumn} ?? '';
                        }
                        return '';
                    }),
                Tables\Columns\TextColumn::make('formatted_amount')
                    ->label('Charge')
                    ->getStateUsing(fn (Model $record): string => $record->method->formattedCharge($record->amount)),
                BadgeColumn::make('method'),

                TextColumn::make('formatted_minimum_order')
                    ->label('Minimum')
                    ->getStateUsing(function(Model $record): string {
                        return $record->minimum_order ? $record->formatted_minimum_order : "\u{2014}";
                    }),
                TextColumn::make('formatted_maximum_order')
                    ->label('Maximum')
                    ->getStateUsing(function(Model $record): string {
                        return $record->maximum_order ? $record->formatted_maximum_order : "\u{2014}";
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                        $data['calculable_type'] = $livewire->ownerRecord->rule_type->calculableType();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                        $data['calculable_type'] = $livewire->ownerRecord->rule_type->calculableType();
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    // public static function canViewForRecord(Model $ownerRecord): bool
    // {
    //     return $ownerRecord->rule_type !== ShippingRules::FREE;
    // }
}
