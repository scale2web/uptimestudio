<?php

namespace App\Filament\Dashboard\Resources\AMCriticalityResource\Pages;

use App\Filament\Dashboard\Resources\AMCriticalityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMCriticality extends EditRecord
{
    protected static string $resource = AMCriticalityResource::class;

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
