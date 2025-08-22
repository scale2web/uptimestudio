<?php

namespace App\Filament\Dashboard\Resources\AMWorkerResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAMWorkers extends ListRecords
{
    protected static string $resource = AMWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_settings')
                ->label('Back to Settings')
                ->url(route('filament.dashboard.pages.settings', ['tenant' => \Filament\Facades\Filament::getTenant()]))
                ->icon('heroicon-o-arrow-left')
                ->color('gray'),
            Actions\Action::make('go_to_worker_groups')
                ->label('Worker Groups')
                ->url(route('filament.dashboard.resources.a-m-worker-groups.index', ['tenant' => \Filament\Facades\Filament::getTenant()]))
                ->icon('heroicon-o-user-group')
                ->color('primary'),
            Actions\CreateAction::make(),
        ];
    }
}
