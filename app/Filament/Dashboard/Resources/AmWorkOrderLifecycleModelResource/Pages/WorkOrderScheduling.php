<?php

namespace App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource\Pages;

use App\Filament\Dashboard\Resources\AmWorkOrderLifecycleModelResource;
use Filament\Resources\Pages\Page;

class WorkOrderScheduling extends Page
{
    protected static string $resource = AmWorkOrderLifecycleModelResource::class;

    protected static string $view = 'filament.dashboard.resources.am-work-order-lifecycle-model-resource.pages.work-order-scheduling';
}
