<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmMaintenanceLifecycleState extends Model
{
    use HasFactory;

    protected $table = 'am_maintenance_lifecycle_states';

    protected $fillable = [
        'lifecycle_state',
        'name',
        'allow_create_maintenance_orders',
        'allow_create_preventive_orders',
        'allow_delete_maintenance_request',
        'allow_installation',
        'allow_removal',
        'allow_rename_maintenance_request',
        'maintenance_request_active',
        'tenant_id',
    ];

    protected $casts = [
        'allow_create_maintenance_orders' => 'boolean',
        'allow_create_preventive_orders' => 'boolean',
        'allow_delete_maintenance_request' => 'boolean',
        'allow_installation' => 'boolean',
        'allow_removal' => 'boolean',
        'allow_rename_maintenance_request' => 'boolean',
        'maintenance_request_active' => 'boolean',
    ];

    /**
     * Get the tenant that owns the maintenance lifecycle state.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the maintenance requests that use this lifecycle state.
     */
    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(AmMaintenanceRequest::class, 'am_maintenance_lifecycle_state_id');
    }

    /**
     * Get the display name for the lifecycle state.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?? $this->lifecycle_state;
    }
}
