<?php

namespace App\Filament\Dashboard\Resources\AMAssetTreeResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetTreeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMAssetTree extends EditRecord
{
    protected static string $resource = AMAssetTreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 