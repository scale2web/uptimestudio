<?php

namespace App\Filament\Dashboard\Resources\AmWorkOrderLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmWorkOrderLifecycleStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmWorkOrderLifecycleStates extends ListRecords
{
    protected static string $resource = AmWorkOrderLifecycleStateResource::class;

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
