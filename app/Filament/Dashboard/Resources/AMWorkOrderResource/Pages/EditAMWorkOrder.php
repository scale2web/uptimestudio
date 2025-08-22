<?php

namespace App\Filament\Dashboard\Resources\AMWorkOrderResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMWorkOrder extends EditRecord
{
    protected static string $resource = AMWorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
