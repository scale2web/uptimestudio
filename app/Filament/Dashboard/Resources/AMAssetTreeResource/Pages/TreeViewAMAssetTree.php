<?php

namespace App\Filament\Dashboard\Resources\AMAssetTreeResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetTreeResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use App\Livewire\AssetTreeView;

class TreeViewAMAssetTree extends Page
{
    protected static string $resource = AMAssetTreeResource::class;

    protected static string $view = 'filament.dashboard.resources.am-asset-tree-resource.pages.tree-view-am-asset-tree';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('list_view')
                ->label(__('List View'))
                ->icon('heroicon-o-list-bullet')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('Asset Tree View');
    }

    public function getHeading(): string
    {
        return __('Asset Hierarchy');
    }

    public function getSubheading(): ?string
    {
        return __('View and manage your assets in a hierarchical tree structure');
    }
} 