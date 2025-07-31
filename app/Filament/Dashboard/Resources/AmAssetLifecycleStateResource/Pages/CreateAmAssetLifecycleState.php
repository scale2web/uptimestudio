<?php

namespace App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAmAssetLifecycleState extends CreateRecord
{
    protected static string $resource = AmAssetLifecycleStateResource::class;

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
