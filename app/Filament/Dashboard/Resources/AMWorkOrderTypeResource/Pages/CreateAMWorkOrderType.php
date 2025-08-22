<?php

namespace App\Filament\Dashboard\Resources\AMWorkOrderTypeResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkOrderTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAMWorkOrderType extends CreateRecord
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
        ];
    }
}
