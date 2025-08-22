<?php

namespace App\Filament\Dashboard\Resources\AMMaintenanceJobTypeResource\Pages;

use App\Filament\Dashboard\Resources\AMMaintenanceJobTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAMMaintenanceJobTypes extends ListRecords
{
    protected static string $resource = AMMaintenanceJobTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_settings')
                ->label(__('Back to Settings'))
                ->url(route('filament.dashboard.pages.settings', ['tenant' => \Filament\Facades\Filament::getTenant()]))
                ->icon('heroicon-m-arrow-left')
                ->color('gray'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            //
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            //
        ];
    }
}
