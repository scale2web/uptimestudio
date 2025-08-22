<?php

namespace App\Filament\Dashboard\Resources\AMMaintenanceJobTypeCategoryResource\Pages;

use App\Filament\Dashboard\Resources\AMMaintenanceJobTypeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAMMaintenanceJobTypeCategories extends ListRecords
{
    protected static string $resource = AMMaintenanceJobTypeCategoryResource::class;

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
