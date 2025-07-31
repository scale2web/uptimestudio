<?php

namespace App\Filament\Admin\Resources\AmAssetLifecycleModelResource\Pages;

use App\Filament\Admin\Resources\AmAssetLifecycleModelResource;
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
