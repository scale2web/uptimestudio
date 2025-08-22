<?php

namespace App\Filament\Dashboard\Resources\AmAssetTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmAssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmAssetType extends EditRecord
{
    protected static string $resource = AmAssetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_settings')
                ->label(__('Back to Settings'))
                ->url(route('filament.dashboard.pages.settings', ['tenant' => \Filament\Facades\Filament::getTenant()]))
                ->icon('heroicon-m-arrow-left')
                ->color('gray'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
