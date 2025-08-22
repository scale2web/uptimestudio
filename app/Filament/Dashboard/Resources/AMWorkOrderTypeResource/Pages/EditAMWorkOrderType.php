<?php

namespace App\Filament\Dashboard\Resources\AMWorkOrderTypeResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkOrderTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMWorkOrderType extends EditRecord
{
    protected static string $resource = AMWorkOrderTypeResource::class;

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
}
