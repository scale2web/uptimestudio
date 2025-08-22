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
