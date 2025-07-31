<?php

namespace App\Filament\Dashboard\Resources\AmAssetLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetLifecycleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmAssetLifecycleModel extends EditRecord
{
    protected static string $resource = AmAssetLifecycleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
