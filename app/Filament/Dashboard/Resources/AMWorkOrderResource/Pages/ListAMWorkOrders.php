<?php

namespace App\Filament\Dashboard\Resources\AMWorkOrderResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAMWorkOrders extends ListRecords
{
    protected static string $resource = AMWorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
