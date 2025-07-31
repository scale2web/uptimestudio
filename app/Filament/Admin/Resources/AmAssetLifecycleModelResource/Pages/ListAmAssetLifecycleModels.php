<?php

namespace App\Filament\Admin\Resources\AmAssetLifecycleModelResource\Pages;

use App\Filament\Admin\Resources\AmAssetLifecycleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmAssetLifecycleModels extends ListRecords
{
    protected static string $resource = AmAssetLifecycleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
