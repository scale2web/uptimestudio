<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAmFunctionalLocationLifecycleState extends CreateRecord
{
    protected static string $resource = AmFunctionalLocationLifecycleStateResource::class;

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
