<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmFunctionalLocationLifecycleState extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_state',
        'name',
        'allow_delete_location',
        'allow_install_maintenance_assets',
        'allow_new_sub_locations',
        'allow_rename_location',
        'create_location_maintenance_asset',
        'functional_location_active',
        'maintenance_asset_lifecycle_state_id',
        'lifecycle_model_id',
        'tenant_id',
    ];

    protected $casts = [
        'allow_delete_location' => 'boolean',
        'allow_install_maintenance_assets' => 'boolean',
        'allow_new_sub_locations' => 'boolean',
        'allow_rename_location' => 'boolean',
        'create_location_maintenance_asset' => 'boolean',
        'functional_location_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocationLifecycleModel::class, 'lifecycle_model_id');
    }

    public function sequences(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationLifecycleStateSequence::class, 'lifecycle_state_id');
    }

    public function functionalLocations(): HasMany
    {
        return $this->hasMany(AmFunctionalLocation::class, 'am_asset_lifecycle_states_id');
    }
}
