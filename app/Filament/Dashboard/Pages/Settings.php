<?php

namespace App\Filament\Dashboard\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationLifecycleStateResource;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class Settings extends Page
{
    //protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.dashboard.pages.settings';

    protected static ?string $slug = 'settings';

    public static function getNavigationLabel(): string
    {
        return __('Settings Hub');
    }

    public function getTitle(): string
    {
        return __('Settings');
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            // Remove the problematic action for now
        ];
    }
}
