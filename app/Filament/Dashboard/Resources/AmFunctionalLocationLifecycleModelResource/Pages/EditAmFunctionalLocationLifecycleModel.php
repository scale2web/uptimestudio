<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmFunctionalLocationLifecycleModel extends EditRecord
{
    protected static string $resource = AmFunctionalLocationLifecycleModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
