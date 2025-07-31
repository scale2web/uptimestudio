<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class AmFunctionalLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'functional_location',
        'name',
        'am_parent_functional_location_id',
        'default_dimension_display_value',
        'am_asset_lifecycle_states_id',
        'am_functional_location_types_id',
        'inventory_location_id',
        'inventory_site_id',
        'logistics_location_id',
        'notes',
        'tenant_id',
    ];

    protected $casts = [
        'default_dimension_display_value' => 'decimal:2',
    ];

    /**
     * Get the tenant that owns the functional location.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the parent functional location.
     */
    public function parentLocation(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocation::class, 'am_parent_functional_location_id');
    }

    /**
     * Get the child functional locations.
     */
    public function childLocations(): HasMany
    {
        return $this->hasMany(AmFunctionalLocation::class, 'am_parent_functional_location_id');
    }

    /**
     * Get all descendants (recursive children).
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(AmFunctionalLocation::class, 'am_parent_functional_location_id');
    }

    /**
     * Get the functional location type.
     */
    public function functionalLocationType(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocationType::class, 'am_functional_location_types_id');
    }

    /**
     * Get the lifecycle state.
     */
    public function lifecycleState(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocationLifecycleState::class, 'am_asset_lifecycle_states_id');
    }

    /**
     * Scope to get root locations (no parent).
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('am_parent_functional_location_id');
    }

    /**
     * Get the full hierarchical path.
     */
    public function getFullPathAttribute(): string
    {
        $path = $this->getAttribute('functional_location');
        $parent = $this->parentLocation;

        while ($parent) {
            $path = $parent->getAttribute('functional_location') . ' > ' . $path;
            $parent = $parent->parentLocation;
        }

        return $path;
    }

    /**
     * Get the depth level in the hierarchy.
     */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parentLocation;

        while ($parent) {
            $depth++;
            $parent = $parent->parentLocation;
        }

        return $depth;
    }

    /**
     * Boot the model and add global scopes.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set tenant_id when creating
        static::creating(function ($model) {
            if (!$model->tenant_id && Auth::check()) {
                $model->tenant_id = Auth::user()->current_tenant_id;
            }
        });
    }
}
