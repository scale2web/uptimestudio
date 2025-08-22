<?php

namespace App\Filament\Dashboard\Resources\AmMaintenanceLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmMaintenanceLifecycleStateResource;
use App\Filament\Dashboard\Pages\Settings;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmMaintenanceLifecycleState extends EditRecord
{
    protected static string $resource = AmMaintenanceLifecycleStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_settings')
                ->label(__('Back to Settings'))
                ->url(Settings::getUrl())
                ->icon('heroicon-m-arrow-left')
                ->color('gray'),
            Actions\DeleteAction::make(),
        ];
    }
}
