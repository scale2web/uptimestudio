<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmFunctionalLocationType extends EditRecord
{
    protected static string $resource = AmFunctionalLocationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
