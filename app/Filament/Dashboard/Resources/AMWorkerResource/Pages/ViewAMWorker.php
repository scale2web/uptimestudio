<?php

namespace App\Filament\Dashboard\Resources\AMWorkerResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAMWorker extends ViewRecord
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
            Actions\EditAction::make(),
        ];
    }
}
