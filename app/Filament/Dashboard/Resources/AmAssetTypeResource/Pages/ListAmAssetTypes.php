<?php

namespace App\Filament\Dashboard\Resources\AmAssetTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmAssetTypes extends ListRecords
{
    protected static string $resource = AmAssetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
