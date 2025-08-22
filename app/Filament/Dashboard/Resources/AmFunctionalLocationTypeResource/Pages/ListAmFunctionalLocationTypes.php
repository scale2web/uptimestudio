<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmFunctionalLocationTypes extends ListRecords
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
