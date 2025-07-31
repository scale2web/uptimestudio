<?php

namespace App\Filament\Dashboard\Resources\AmAssetTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAmAssetType extends CreateRecord
{
    protected static string $resource = AmAssetTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = \Filament\Facades\Filament::getTenant()->id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
