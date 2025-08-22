<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAmFunctionalLocationLifecycleModel extends CreateRecord
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
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically assign the current tenant
        $data['tenant_id'] = Filament::getTenant()->id;

        return $data;
    }
}
