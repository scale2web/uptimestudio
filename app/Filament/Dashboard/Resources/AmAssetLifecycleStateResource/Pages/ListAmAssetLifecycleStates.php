<?php

namespace App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetLifecycleStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmAssetLifecycleStates extends ListRecords
{
    protected static string $resource = AmAssetLifecycleStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
