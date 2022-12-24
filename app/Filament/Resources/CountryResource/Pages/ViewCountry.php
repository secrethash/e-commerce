<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Facades\Filament;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewCountry extends ViewRecord
{
    protected static string $resource = CountryResource::class;

    protected function getActions(): array
    {
        $record = $this->record;
        return [
            // Actions\CreateAction::make(),
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
                    if ($record->pricing()->count() < 1 && !$record->is_active) {
                        Filament::notify(
                            'danger',
                            'Please make sure there is atleast one Pricing Rule present before activating.'
                        );
                    } else {
                        $record->update([
                            'is_active' => !$record->is_active
                        ]);
                    }
                })
                ->icon(fn() =>
                    $this->record->is_active ?
                    'heroicon-o-x-circle' : 'heroicon-o-check-circle'
                ),
        ];
    }
}
