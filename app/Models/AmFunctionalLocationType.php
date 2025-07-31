<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmFunctionalLocationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'functional_location_type',
        'name',
        'allow_multiple_installed_assets',
        'update_asset_dimension',
        'am_asset_lifecycle_model_id',
        'am_asset_type_id',
        'tenant_id',
    ];

    protected $casts = [
        'allow_multiple_installed_assets' => 'boolean',
        'update_asset_dimension' => 'boolean',
    ];

    /**
     * Get the tenant that owns the functional location type.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the asset lifecycle model for this functional location type.
     */
    public function assetLifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmAssetLifecycleModel::class, 'am_asset_lifecycle_model_id');
    }

    /**
     * Get the asset type for this functional location type (optional).
     */
    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AmAssetType::class, 'am_asset_type_id');
    }

    /**
     * Get the functional locations that use this type.
     */
    public function functionalLocations(): HasMany
    {
        return $this->hasMany(AmFunctionalLocation::class, 'am_functional_location_types_id');
    }
}
