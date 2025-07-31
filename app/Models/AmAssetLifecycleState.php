<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmAssetLifecycleState extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_state',
        'name',
        'allow_create_maintenance_orders',
        'allow_create_preventive_orders',
        'allow_delete_asset',
        'allow_installation',
        'allow_removal',
        'allow_rename_asset',
        'asset_active',
        'tenant_id',
    ];

    protected $casts = [
        'allow_create_maintenance_orders' => 'boolean',
        'allow_create_preventive_orders' => 'boolean',
        'allow_delete_asset' => 'boolean',
        'allow_installation' => 'boolean',
        'allow_removal' => 'boolean',
        'allow_rename_asset' => 'boolean',
        'asset_active' => 'boolean',
    ];

    /**
     * Get the tenant that owns the asset lifecycle state.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the sequences that use this asset lifecycle state.
     */
    public function sequences(): HasMany
    {
        return $this->hasMany(AmAssetLifecycleStateSequence::class, 'lifecycle_state_id');
    }
}
