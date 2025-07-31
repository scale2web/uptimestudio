<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmFunctionalLocations extends ListRecords
{
    protected static string $resource = AmFunctionalLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('tree_view')
                ->label('Tree View')
                ->icon('heroicon-o-squares-2x2')
                ->url(AmFunctionalLocationResource::getUrl('tree'))
                ->color('info'),
            Actions\CreateAction::make(),
        ];
    }
}
