<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use App\Models\Enums\UsedFor;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photograph';

    protected static ?string $navigationGroup = 'content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', slugify_model(Banner::class, $state)))
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive(),
                Forms\Components\Select::make('used_for')
                    ->label('Used For')
                    ->options(UsedFor::toArray())
                    ->in(UsedFor::values())
                    ->required()
                    ->searchable(),
                SpatieMediaLibraryFileUpload::make('banner')
                    ->label('Banner Image'),
                Forms\Components\TextInput::make('subtitle')
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->maxLength(255),
                RichEditor::make('details')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                    ])->maxLength(65535)->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->url()
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('link_text')
                    ->default('Shop Now')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_bg_dark')
                    ->label('Has Dark Background?')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('banner')
                    ->label('Image')
                    ->conversion('preview'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('used')
                    ->label('For')
                    ->default(fn($record) => UsedFor::from($record->used_for->value)->text()),
                Tables\Columns\TextColumn::make('link_text')
                    ->label('Link')
                    ->url(fn(Model $record):string => $record->link)
                    ->wrap()
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('is_bg_dark')
                    ->label('Dark')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBanners::route('/'),
        ];
    }
}
