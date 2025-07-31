<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmAssetLifecycleModel extends Model
{
    use HasFactory;

    protected $table = 'am_asset_lifecycle_models';

    protected $fillable = [
        'tenant_id',
        'lifecycle_model_name',
        'name',
    ];

    /**
     * Get the tenant that owns the asset lifecycle model.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the sequences for this asset lifecycle model.
     */
    public function sequences(): HasMany
    {
        return $this->hasMany(AmAssetLifecycleStateSequence::class, 'lifecycle_model_id');
    }

    /**
     * Get the asset types that use this lifecycle model.
     */
    public function assetTypes(): HasMany
    {
        return $this->hasMany(AmAssetType::class, 'am_asset_lifecycle_model_id');
    }

    /**
     * Get the functional location types that use this lifecycle model.
     */
    public function functionalLocationTypes(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationType::class, 'am_asset_lifecycle_model_id');
    }
}
