<?php

namespace App\Filament\Dashboard\Resources\AMAssetResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAMAssets extends ListRecords
{
    protected static string $resource = AMAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
