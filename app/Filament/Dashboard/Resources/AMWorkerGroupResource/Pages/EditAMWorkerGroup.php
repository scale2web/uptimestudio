<?php

namespace App\Filament\Dashboard\Resources\AMWorkerGroupResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkerGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMWorkerGroup extends EditRecord
{
    protected static string $resource = AMWorkerGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_settings')
                ->label('Back to Settings')
                ->url(route('filament.dashboard.pages.settings', ['tenant' => \Filament\Facades\Filament::getTenant()]))
                ->icon('heroicon-o-arrow-left')
                ->color('gray'),
            Actions\DeleteAction::make(),
        ];
    }
}
