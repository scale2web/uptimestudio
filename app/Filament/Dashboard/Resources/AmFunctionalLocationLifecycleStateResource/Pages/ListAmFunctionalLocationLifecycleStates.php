<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmFunctionalLocationLifecycleStates extends ListRecords
{
    protected static string $resource = AmFunctionalLocationLifecycleStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
