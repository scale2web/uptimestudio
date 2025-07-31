<?php

namespace App\Filament\Dashboard\Resources\AMAssetTreeResource\Pages;

use App\Filament\Dashboard\Resources\AMAssetTreeResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;

class AssemblyViewAMAssetTree extends Page
{
    protected static string $resource = AMAssetTreeResource::class;

    protected static string $view = 'filament.dashboard.resources.am-asset-tree-resource.pages.assembly-view-am-asset-tree';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('list_view')
                ->label(__('List View'))
                ->icon('heroicon-o-list-bullet')
                ->url(static::getResource()::getUrl('index'))
                ->color('gray'),
            Actions\Action::make('tree_view')
                ->label(__('Tree View'))
                ->icon('heroicon-o-rectangle-stack')
                ->url(static::getResource()::getUrl('tree-view'))
                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('Asset Assemblies');
    }

    public function getHeading(): string
    {
        return __('Asset Assembly Management');
    }

    public function getSubheading(): ?string
    {
        return __('View and manage complex asset assemblies like engines, production lines, and equipment systems');
    }
} 