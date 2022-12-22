<?php

namespace App\Filament\Resources\CarrierResource\Pages;

use App\Filament\Resources\CarrierResource;
use App\Models\Enums\ShippingRules;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCarrier extends EditRecord
{
    protected static string $resource = CarrierResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if(isset($data['rule_type']) && ShippingRules::tryFrom($data['rule_type'])->freeable()) {
            $data['shipping_amount'] = 0;
        }

        return $data;
    }

    protected function getActions(): array
    {
        $record = $this->record;
        return [
            Action::make('switch-state')
                ->label(fn() =>
                        $this->record->is_enabled ?
                        'Deactivate' : 'Activate'
                    )
                ->color(fn() =>
                    $this->record->is_enabled ?
                    'secondary' : 'success'
                )
                ->action(function() use($record) {
                    if ($record->pricing()->count() < 1 && !$record->is_enabled) {
                        Filament::notify(
                            'danger',
                            'Please make sure there is atleast one Pricing Rule present before activating.'
                        );
                    } else {
                        $record->update([
                            'is_enabled' => !$record->is_enabled
                        ]);
                    }
                })
                ->icon(fn() =>
                    $this->record->is_enabled ?
                    'heroicon-o-x-circle' : 'heroicon-o-check-circle'
                ),
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return false;
    }
}
