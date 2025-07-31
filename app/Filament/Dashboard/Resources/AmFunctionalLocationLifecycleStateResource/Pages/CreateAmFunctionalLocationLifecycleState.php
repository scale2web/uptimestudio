<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAmFunctionalLocationLifecycleState extends CreateRecord
{
    protected static string $resource = AmFunctionalLocationLifecycleStateResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically assign the current tenant
        $data['tenant_id'] = Filament::getTenant()->id;

        return $data;
    }
}
