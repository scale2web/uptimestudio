<?php

namespace App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmWorkOrderLifecycleModel extends EditRecord
{
    protected static string $resource = AmWorkOrderLifecycleModelResource::class;

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
