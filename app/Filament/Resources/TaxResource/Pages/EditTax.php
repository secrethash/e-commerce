<?php

namespace App\Filament\Resources\TaxResource\Pages;

use App\Filament\Resources\TaxResource;
use App\Models\TaxGroup;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditTax extends EditRecord
{
    protected static string $resource = TaxResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['tax_group_id'] = TaxGroup::default()->first()?->id;

        return $data;
    }

    protected function getActions(): array
    {
        $record = $this->record;
        return [
            Action::make('switch-state')
                ->label(fn() =>
                        $this->record->is_active ?
                        'Deactivate' : 'Activate'
                    )
                ->color(fn() =>
                    $this->record->is_active ?
                    'secondary' : 'success'
                )
                ->action(function() use($record) {
                    $record->update([
                        'is_active' => !$record->is_active
                    ]);
                })
                ->icon(fn() =>
                    $this->record->is_active ?
                    'heroicon-o-x-circle' : 'heroicon-o-check-circle'
                ),
            Actions\DeleteAction::make(),
        ];
    }
}
