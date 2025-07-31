<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmAssetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_asset_type',
        'name',
        'calculate_kpi_total',
        'am_asset_lifecycle_model_id',
        'tenant_id',
    ];

    protected $casts = [
        'calculate_kpi_total' => 'boolean',
    ];

    /**
     * Get the tenant that owns the asset type.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the asset lifecycle model for this asset type.
     */
    public function assetLifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmAssetLifecycleModel::class, 'am_asset_lifecycle_model_id');
    }

    /**
     * Get the functional location types that use this asset type.
     */
    public function functionalLocationTypes(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationType::class, 'am_asset_type_id');
    }
}
