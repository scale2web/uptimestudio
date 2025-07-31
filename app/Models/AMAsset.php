<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AMAsset extends Model
{
    protected $table = 'am_assets';

    protected $fillable = [
        'maintenance_asset',
        'acquisition_cost',
        'acquisition_date',
        'active_from',
        'active_to',
        'default_dimension_display_value',
        'fixed_asset_id',
        'am_functional_location_id',
        'logistics_location_id',
        'am_asset_lifecycle_state_id',
        'am_asset_type_id',
        'model_id',
        'model_product_id',
        'model_year',
        'name',
        'notes',
        'parent_maintenance_asset_id',
        'product_id',
        'purchase_order_id',
        'replacement_date',
        'replacement_value',
        'serial_id',
        'vend_account',
        'warranty_date_from_vend',
        'warranty_id',
        'wrk_ctr_id',
        'tenant_id',
    ];

    public function assetType()
    {
        return $this->belongsTo(AmAssetType::class, 'am_asset_type_id');
    }

    public function lifecycleState()
    {
        return $this->belongsTo(AmAssetLifecycleState::class, 'am_asset_lifecycle_state_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function functionalLocation()
    {
        return $this->belongsTo(AmFunctionalLocation::class, 'am_functional_location_id');
    }

    public function parent()
    {
        return $this->belongsTo(AMAsset::class, 'parent_maintenance_asset_id');
    }

    public function children()
    {
        return $this->hasMany(AMAsset::class, 'parent_maintenance_asset_id');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function getAllDescendants()
    {
        return $this->children()->with('descendants')->get();
    }

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    public function getAllAncestors()
    {
        return $this->parent()->with('ancestors')->get();
    }

    public function getFullPathAttribute()
    {
        $path = collect([$this]);
        $current = $this;
        
        while ($current->parent) {
            $current = $current->parent;
            $path->prepend($current);
        }
        
        return $path;
    }
}
