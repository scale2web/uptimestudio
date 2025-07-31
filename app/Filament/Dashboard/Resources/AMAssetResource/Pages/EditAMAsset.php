<?php

namespace App\Filament\Dashboard\Resources\AMAssetResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAMAsset extends EditRecord
{
    protected static string $resource = AMAssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Check if we should return to tree view
        if (request()->get('return_to') === 'tree_view') {
            return route('filament.dashboard.resources.a-m-asset-trees.tree-view', [
                'tenant' => \Filament\Facades\Filament::getTenant()->uuid
            ]);
        }

        // Default redirect to the index page
        return $this->getResource()::getUrl('index');
    }
}
