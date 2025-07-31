<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleModelResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateAmFunctionalLocationLifecycleModel extends CreateRecord
{
    protected static string $resource = AmFunctionalLocationLifecycleModelResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = Filament::getTenant()->id;

        return $data;
    }
}
