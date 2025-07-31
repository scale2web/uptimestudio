<?php

namespace App\Filament\Dashboard\Resources\AmFunctionalLocationResource\Pages;

use App\Filament\Dashboard\Resources\AmFunctionalLocationResource;
use App\Models\AmFunctionalLocation;
use Filament\Resources\Pages\Page;
use Filament\Actions;
use Illuminate\Contracts\View\View;

class TreeViewAmFunctionalLocations extends Page
{
    protected static string $resource = AmFunctionalLocationResource::class;

    protected static string $view = 'filament.dashboard.resources.am-functional-location.pages.tree-view';

    protected static ?string $title = 'Functional Locations Tree View';

    protected static ?string $navigationLabel = 'Tree View';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public function getViewData(): array
    {
        $rootLocations = AmFunctionalLocation::whereNull('am_parent_functional_location_id')
            ->with(['childLocations.childLocations.childLocations.childLocations']) // Load deep relationships
            ->orderBy('functional_location')
            ->get();

        return [
            'rootLocations' => $rootLocations,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(AmFunctionalLocationResource::getUrl('create'))
                ->label('Create Functional Location'),
        ];
    }

    public function countLocations(AmFunctionalLocation $location): int
    {
        $count = 1; // Count this location
        foreach ($location->childLocations as $child) {
            $count += $this->countLocations($child);
        }
        return $count;
    }

    public function maxDepth(AmFunctionalLocation $location, int $currentDepth = 0): int
    {
        $maxDepth = $currentDepth;
        foreach ($location->childLocations as $child) {
            $childDepth = $this->maxDepth($child, $currentDepth + 1);
            $maxDepth = max($maxDepth, $childDepth);
        }
        return $maxDepth;
    }

    public function countLeafNodes(AmFunctionalLocation $location): int
    {
        if ($location->childLocations->count() === 0) {
            return 1; // This is a leaf node
        }

        $count = 0;
        foreach ($location->childLocations as $child) {
            $count += $this->countLeafNodes($child);
        }
        return $count;
    }

    public function viewModal(AmFunctionalLocation $record)
    {
        // Load the record with relationships
        $record->load(['parentLocation', 'childLocations', 'functionalLocationType', 'functionalLocationLifecycleState']);

        return view('filament.dashboard.resources.am-functional-location.modals.view-modal', [
            'record' => $record
        ]);
    }

    public function editModal(AmFunctionalLocation $record)
    {
        return view('filament.dashboard.resources.am-functional-location.modals.edit-modal', [
            'record' => $record
        ]);
    }
}
