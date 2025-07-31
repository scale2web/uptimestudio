<?php

namespace App\Livewire;

use App\Models\AMAsset;
use Livewire\Component;

class AssetTreeView extends Component
{
    public $expandedNodes = [];
    public $search = '';
    public $selectedAssetType = '';
    public $selectedLifecycleState = '';

    public function mount()
    {
        $this->expandedNodes = [];
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
        $assetIds = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->pluck('id')
            ->toArray();
        $this->expandedNodes = $assetIds;
    }

    public function collapseAll()
    {
        $this->expandedNodes = [];
    }

    public function getRootAssets()
    {
        $query = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->whereNull('parent_maintenance_asset_id')
            ->with(['children.assetType', 'children.lifecycleState', 'children.functionalLocation', 'assetType', 'lifecycleState', 'functionalLocation']);

        if ($this->search) {
            // When searching, only show root assets that either match the search or have matching children
            $query->where(function ($q) {
                $q->where('maintenance_asset', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%")
                  ->orWhereHas('children', function ($childQuery) {
                      $childQuery->where('maintenance_asset', 'like', "%{$this->search}%")
                                ->orWhere('name', 'like', "%{$this->search}%");
                  });
            });
        }

        if ($this->selectedAssetType) {
            $query->where('am_asset_type_id', $this->selectedAssetType);
        }

        if ($this->selectedLifecycleState) {
            $query->where('am_asset_lifecycle_state_id', $this->selectedLifecycleState);
        }

        return $query->orderBy('maintenance_asset')->get();
    }

    public function getChildAssets($parentId)
    {
        $query = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->where('parent_maintenance_asset_id', $parentId)
            ->with(['children.assetType', 'children.lifecycleState', 'children.functionalLocation', 'assetType', 'lifecycleState', 'functionalLocation']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('maintenance_asset', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
            });
        }

        if ($this->selectedAssetType) {
            $query->where('am_asset_type_id', $this->selectedAssetType);
        }

        if ($this->selectedLifecycleState) {
            $query->where('am_asset_lifecycle_state_id', $this->selectedLifecycleState);
        }

        return $query->orderBy('maintenance_asset')->get();
    }

    public function getAssetPath($assetId)
    {
        $asset = AMAsset::find($assetId);
        if (!$asset) {
            return collect();
        }
        
        return $asset->full_path;
    }

    public function assetMatchesSearch($asset)
    {
        if (!$this->search) {
            return true;
        }
        
        return stripos($asset->maintenance_asset, $this->search) !== false ||
               stripos($asset->name, $this->search) !== false;
    }

    public function hasMatchingChildren($asset)
    {
        if (!$this->search) {
            return false;
        }
        
        foreach ($asset->children as $child) {
            if ($this->assetMatchesSearch($child) || $this->hasMatchingChildren($child)) {
                return true;
            }
        }
        
        return false;
    }

    public function shouldShowAsset($asset)
    {
        if (!$this->search) {
            return true;
        }
        
        return $this->assetMatchesSearch($asset) || $this->hasMatchingChildren($asset);
    }

    public function updatedSearch()
    {
        // This method will be called whenever the search property is updated
        if ($this->search) {
            // Find all assets that match the search
            $matchingAssets = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                ->where(function ($q) {
                    $q->where('maintenance_asset', 'like', "%{$this->search}%")
                      ->orWhere('name', 'like', "%{$this->search}%");
                })
                ->get();

            // Get all parent IDs that need to be expanded to show matching assets
            $parentIds = [];
            foreach ($matchingAssets as $asset) {
                $path = $asset->full_path;
                foreach ($path as $pathAsset) {
                    if ($pathAsset->parent_maintenance_asset_id) {
                        $parentIds[] = $pathAsset->parent_maintenance_asset_id;
                    }
                }
            }
            
            // Auto-expand the nodes to show search results
            $this->expandedNodes = array_unique($parentIds);
        } else {
            // Clear expanded nodes when search is cleared
            $this->expandedNodes = [];
        }
        
        // Force a re-render
        $this->dispatch('search-updated');
    }

    public function render()
    {
        $rootAssets = $this->getRootAssets();
        
        return view('livewire.asset-tree-view', [
            'rootAssets' => $rootAssets,
        ]);
    }

    public function debugSearch()
    {
        // Debug method to test search functionality
        $matchingAssets = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->where(function ($q) {
                $q->where('maintenance_asset', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%");
            })
            ->get();
        
        return $matchingAssets->count();
    }

    public function performSearch()
    {
        // Manual search method that can be triggered by button click
        if ($this->search) {
            $matchingAssets = AMAsset::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                ->where(function ($q) {
                    $q->where('maintenance_asset', 'like', "%{$this->search}%")
                      ->orWhere('name', 'like', "%{$this->search}%");
                })
                ->get();

            $parentIds = [];
            foreach ($matchingAssets as $asset) {
                $path = $asset->full_path;
                foreach ($path as $pathAsset) {
                    if ($pathAsset->parent_maintenance_asset_id) {
                        $parentIds[] = $pathAsset->parent_maintenance_asset_id;
                    }
                }
            }
            
            $this->expandedNodes = array_unique($parentIds);
        } else {
            $this->expandedNodes = [];
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->expandedNodes = [];
    }

    public function openEditModal($assetId)
    {
        $this->dispatch('open-asset-edit-modal', assetId: $assetId);
    }

    protected $listeners = ['asset-updated' => '$refresh'];
} 