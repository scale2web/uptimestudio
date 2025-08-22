<?php

namespace App\Livewire;

use App\Models\AMAsset;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;

class AssetEditModal extends Component
{
    public $showModal = false;
    public $assetId = null;
    public $asset = null;
    
    // Form properties - Basic Information
    public $maintenance_asset = '';
    public $name = '';
    public $am_asset_type_id = '';
    public $am_asset_lifecycle_state_id = '';
    
    // Location & Installation
    public $am_functional_location_id = '';
    public $parent_maintenance_asset_id = '';
    public $logistics_location_id = '';
    
    // Financial Information
    public $acquisition_cost = '';
    public $replacement_value = '';
    public $acquisition_date = '';
    public $replacement_date = '';
    
    // Operational Details
    public $active_from = '';
    public $active_to = '';
    public $model_id = '';
    public $model_year = '';
    public $serial_id = '';
    public $product_id = '';
    
    // Warranty & Vendor
    public $vend_account = '';
    public $warranty_date_from_vend = '';
    public $warranty_id = '';
    public $purchase_order_id = '';
    
    // Additional Information
    public $notes = '';
    public $default_dimension_display_value = '';
    public $fixed_asset_id = '';
    public $wrk_ctr_id = '';

    protected $listeners = ['open-asset-edit-modal' => 'openModal'];

    public function openModal($assetId)
    {
        $this->assetId = $assetId;
        $this->asset = AMAsset::find($assetId);
        
        if ($this->asset) {
            // Debug: Let's see what data we have
            \Log::info('Asset data:', [
                'id' => $this->asset->id,
                'maintenance_asset' => $this->asset->maintenance_asset,
                'name' => $this->asset->name,
                'am_asset_type_id' => $this->asset->am_asset_type_id,
                'am_asset_lifecycle_state_id' => $this->asset->am_asset_lifecycle_state_id,
            ]);
            
            // Fill the form properties - Basic Information
            $this->maintenance_asset = $this->asset->maintenance_asset;
            $this->name = $this->asset->name;
            $this->am_asset_type_id = $this->asset->am_asset_type_id;
            $this->am_asset_lifecycle_state_id = $this->asset->am_asset_lifecycle_state_id;
            
            // Location & Installation
            $this->am_functional_location_id = $this->asset->am_functional_location_id;
            $this->parent_maintenance_asset_id = $this->asset->parent_maintenance_asset_id;
            $this->logistics_location_id = $this->asset->logistics_location_id;
            
            // Financial Information
            $this->acquisition_cost = $this->asset->acquisition_cost;
            $this->replacement_value = $this->asset->replacement_value;
            $this->acquisition_date = $this->asset->acquisition_date;
            $this->replacement_date = $this->asset->replacement_date;
            
            // Operational Details
            $this->active_from = $this->asset->active_from;
            $this->active_to = $this->asset->active_to;
            $this->model_id = $this->asset->model_id;
            $this->model_year = $this->asset->model_year;
            $this->serial_id = $this->asset->serial_id;
            $this->product_id = $this->asset->product_id;
            
            // Warranty & Vendor
            $this->vend_account = $this->asset->vend_account;
            $this->warranty_date_from_vend = $this->asset->warranty_date_from_vend;
            $this->warranty_id = $this->asset->warranty_id;
            $this->purchase_order_id = $this->asset->purchase_order_id;
            
            // Additional Information
            $this->notes = $this->asset->notes;
            $this->default_dimension_display_value = $this->asset->default_dimension_display_value;
            $this->fixed_asset_id = $this->asset->fixed_asset_id;
            $this->wrk_ctr_id = $this->asset->wrk_ctr_id;
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->assetId = null;
        $this->asset = null;
        
        // Reset all form properties
        $this->maintenance_asset = '';
        $this->name = '';
        $this->am_asset_type_id = '';
        $this->am_asset_lifecycle_state_id = '';
        $this->am_functional_location_id = '';
        $this->parent_maintenance_asset_id = '';
        $this->logistics_location_id = '';
        $this->acquisition_cost = '';
        $this->replacement_value = '';
        $this->acquisition_date = '';
        $this->replacement_date = '';
        $this->active_from = '';
        $this->active_to = '';
        $this->model_id = '';
        $this->model_year = '';
        $this->serial_id = '';
        $this->product_id = '';
        $this->vend_account = '';
        $this->warranty_date_from_vend = '';
        $this->warranty_id = '';
        $this->purchase_order_id = '';
        $this->notes = '';
        $this->default_dimension_display_value = '';
        $this->fixed_asset_id = '';
        $this->wrk_ctr_id = '';
    }

    public function save()
    {
        $this->validate([
            'maintenance_asset' => 'required|max:255',
            'name' => 'required|max:255',
            'am_asset_type_id' => 'required',
            'am_asset_lifecycle_state_id' => 'required',
        ]);
        
        $this->asset->update([
            'maintenance_asset' => $this->maintenance_asset,
            'name' => $this->name,
            'am_asset_type_id' => $this->am_asset_type_id,
            'am_asset_lifecycle_state_id' => $this->am_asset_lifecycle_state_id,
            'am_functional_location_id' => $this->am_functional_location_id,
            'parent_maintenance_asset_id' => $this->parent_maintenance_asset_id,
            'logistics_location_id' => $this->logistics_location_id,
            'acquisition_cost' => $this->acquisition_cost,
            'replacement_value' => $this->replacement_value,
            'acquisition_date' => $this->acquisition_date,
            'replacement_date' => $this->replacement_date,
            'active_from' => $this->active_from,
            'active_to' => $this->active_to,
            'model_id' => $this->model_id,
            'model_year' => $this->model_year,
            'serial_id' => $this->serial_id,
            'product_id' => $this->product_id,
            'vend_account' => $this->vend_account,
            'warranty_date_from_vend' => $this->warranty_date_from_vend,
            'warranty_id' => $this->warranty_id,
            'purchase_order_id' => $this->purchase_order_id,
            'notes' => $this->notes,
            'default_dimension_display_value' => $this->default_dimension_display_value,
            'fixed_asset_id' => $this->fixed_asset_id,
            'wrk_ctr_id' => $this->wrk_ctr_id,
        ]);
        
        $this->closeModal();
        
        $this->dispatch('asset-updated');
        
        Notification::make()
            ->title(__('Asset updated successfully'))
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.asset-edit-modal');
    }
} 