<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmFunctionalLocationLifecycleModel extends EditRecord
{
    protected static string $resource = AmFunctionalLocationLifecycleModelResource::class;

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
