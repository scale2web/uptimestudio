<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmFunctionalLocation extends EditRecord
{
    protected static string $resource = AmFunctionalLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
