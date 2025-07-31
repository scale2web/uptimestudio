<?php

namespace App\Filament\Dashboard\Resources\AMAssetTreeResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetTreeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAMAssetTrees extends ListRecords
{
    protected static string $resource = AMAssetTreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('tree_view')
                ->label(__('Tree View'))
                ->icon('heroicon-o-rectangle-stack')
                ->url(static::getResource()::getUrl('tree-view'))
                ->color('success'),
            Actions\Action::make('assembly_view')
                ->label(__('Assembly View'))
                ->icon('heroicon-o-cube')
                ->url(static::getResource()::getUrl('assembly-view'))
                ->color('warning'),
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return static::getResource()::getEloquentQuery()
            ->whereNull('parent_maintenance_asset_id') // Only show root assets
            ->with(['children.assetType', 'children.lifecycleState', 'children.functionalLocation'])
            ->orderBy('maintenance_asset', 'asc');
    }
} 