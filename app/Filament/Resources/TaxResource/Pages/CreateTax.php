<?php

namespace App\Filament\Resources\TaxResource\Pages;

use App\Filament\Resources\TaxResource;
use App\Models\TaxGroup;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTax extends CreateRecord
{
    protected static string $resource = TaxResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tax_group_id'] = TaxGroup::default()->first()?->id;

        return $data;
    }
}
