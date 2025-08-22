<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AMWorkOrder extends Model
{
    use HasFactory;

    protected $table = 'am_work_orders';

    protected $fillable = [
        'work_order_id',
        'active',
        'actual_end',
        'actual_start',
        'description',
        'expected_end',
        'expected_start',
        'is_work_order_scheduled_for_single_worker',
        'order_billing_customer_account_number',
        'order_project_contract_id',
        'scheduled_end',
        'scheduled_start',
        'am_cost_type_id',
        'next_work_order_lifecycle_state_id',
        'parent_work_order_id',
        'responsible_worker_personnel_number',
        'scheduled_worker_personnel_number',
        'am_criticality_id',
        'am_worker_group_id',
        'am_work_order_lifecycle_state_id',
        'am_work_order_type_id',
        'tenant_id',
    ];

    protected $casts = [
        'active' => 'boolean',
        'actual_end' => 'datetime',
        'actual_start' => 'datetime',
        'expected_end' => 'datetime',
        'expected_start' => 'datetime',
        'is_work_order_scheduled_for_single_worker' => 'boolean',
        'scheduled_end' => 'datetime',
        'scheduled_start' => 'datetime',
    ];

    /**
     * Get the tenant that owns the work order.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the cost type for this work order.
     */
    public function costType(): BelongsTo
    {
        return $this->belongsTo(AMCostType::class, 'am_cost_type_id');
    }

    /**
     * Get the next work order lifecycle state for this work order.
     */
    public function nextWorkOrderLifecycleState(): BelongsTo
    {
        return $this->belongsTo(AmWorkOrderLifecycleState::class, 'next_work_order_lifecycle_state_id');
    }

    /**
     * Get the parent work order for this work order.
     */
    public function parentWorkOrder(): BelongsTo
    {
        return $this->belongsTo(AMWorkOrder::class, 'parent_work_order_id');
    }

    /**
     * Get the child work orders for this work order.
     */
    public function childWorkOrders(): HasMany
    {
        return $this->hasMany(AMWorkOrder::class, 'parent_work_order_id');
    }

    /**
     * Get the responsible worker for this work order.
     */
    public function responsibleWorker(): BelongsTo
    {
        return $this->belongsTo(AMWorker::class, 'responsible_worker_personnel_number', 'personnel_number');
    }

    /**
     * Get the scheduled worker for this work order.
     */
    public function scheduledWorker(): BelongsTo
    {
        return $this->belongsTo(AMWorker::class, 'scheduled_worker_personnel_number', 'personnel_number');
    }

    /**
     * Get the service level (criticality) for this work order.
     */
    public function serviceLevel(): BelongsTo
    {
        return $this->belongsTo(AMCriticality::class, 'am_criticality_id');
    }

    /**
     * Get the worker group for this work order.
     */
    public function workerGroup(): BelongsTo
    {
        return $this->belongsTo(AMWorkerGroup::class, 'am_worker_group_id');
    }

    /**
     * Get the work order lifecycle state for this work order.
     */
    public function workOrderLifecycleState(): BelongsTo
    {
        return $this->belongsTo(AmWorkOrderLifecycleState::class, 'am_work_order_lifecycle_state_id');
    }

    /**
     * Get the work order type for this work order.
     */
    public function workOrderType(): BelongsTo
    {
        return $this->belongsTo(AMWorkOrderType::class, 'am_work_order_type_id');
    }

    /**
     * Get the display name for the work order.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->work_order_id . ' - ' . $this->description;
    }
}
