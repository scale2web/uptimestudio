<?php

namespace App\Livewire;

use App\Models\AMAsset;
use Livewire\Component;
use Illuminate\Support\Collection;

class AssetAssemblyView extends Component
{
    public $selectedAssembly = null;
    public $expandedNodes = [];
    public $search = '';
    public $selectedAssetType = '';
    public $selectedLifecycleState = '';
    public $assemblyTypes = [];

    public function mount()
    {
        $this->expandedNodes = [];
        $this->loadAssemblyTypes();
    }

    public function loadAssemblyTypes()
    {
        $this->assemblyTypes = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->whereNull('parent_maintenance_asset_id')
            ->with(['assetType'])
            ->get()
            ->filter(function ($asset) {
                // Filter for assets that are likely assemblies (have children or specific types)
                return $asset->children->count() > 0 || 
                       ($asset->assetType && in_array(strtolower($asset->assetType->maintenance_asset_type), ['assembly', 'system', 'equipment', 'machine']));
            });
    }

    public function selectAssembly($assetId)
    {
        $this->selectedAssembly = AMAsset::with([
            'children.assetType', 
            'children.lifecycleState', 
            'children.functionalLocation',
            'children.children.assetType',
            'children.children.lifecycleState',
            'children.children.functionalLocation',
            'assetType', 
            'lifecycleState', 
            'functionalLocation'
        ])->find($assetId);
        
        // Auto-expand the selected assembly
        $this->expandedNodes = [$assetId];
    }

    public function toggleNode($assetId)
    {
        if (in_array($assetId, $this->expandedNodes)) {
            $this->expandedNodes = array_diff($this->expandedNodes, [$assetId]);
        } else {
            $this->expandedNodes[] = $assetId;
        }
    }

    public function isExpanded($assetId)
    {
        return in_array($assetId, $this->expandedNodes);
    }

    public function expandAll()
    {
        if (!$this->selectedAssembly) {
            return;
        }
        
        $this->expandedNodes = $this->getAllAssetIds($this->selectedAssembly);
    }

    public function collapseAll()
    {
        $this->expandedNodes = [];
    }

    private function getAllAssetIds($asset)
    {
        $ids = [$asset->id];
        foreach ($asset->children as $child) {
            $ids = array_merge($ids, $this->getAllAssetIds($child));
        }
        return $ids;
    }

    public function getAssemblyStatistics()
    {
        if (!$this->selectedAssembly) {
            return null;
        }

        $totalComponents = $this->countComponents($this->selectedAssembly);
        $activeComponents = $this->countActiveComponents($this->selectedAssembly);
        $totalValue = $this->calculateTotalValue($this->selectedAssembly);

        return [
            'total_components' => $totalComponents,
            'active_components' => $activeComponents,
            'total_value' => $totalValue,
            'completion_percentage' => $totalComponents > 0 ? ($activeComponents / $totalComponents) * 100 : 0,
        ];
    }

    private function countComponents($asset)
    {
        $count = 1; // Count the asset itself
        foreach ($asset->children as $child) {
            $count += $this->countComponents($child);
        }
        return $count;
    }

    private function countActiveComponents($asset)
    {
        $count = $asset->active_to ? 0 : 1; // Count if active
        foreach ($asset->children as $child) {
            $count += $this->countActiveComponents($child);
        }
        return $count;
    }

    private function calculateTotalValue($asset)
    {
        $value = $asset->acquisition_cost ?? 0;
        foreach ($asset->children as $child) {
            $value += $this->calculateTotalValue($child);
        }
        return $value;
    }

    public function render()
    {
        $statistics = $this->getAssemblyStatistics();
        
        return view('livewire.asset-assembly-view', [
            'assemblyTypes' => $this->assemblyTypes,
            'statistics' => $statistics,
        ]);
    }
} 