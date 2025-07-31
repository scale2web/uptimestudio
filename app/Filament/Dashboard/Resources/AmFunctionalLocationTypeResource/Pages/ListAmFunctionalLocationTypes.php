<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmFunctionalLocationTypes extends ListRecords
{
    protected static string $resource = AmFunctionalLocationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
