<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AMWorkOrderType extends Model
{
    use HasFactory;

    protected $table = 'am_work_order_types';

    protected $fillable = [
        'work_order_type',
        'name',
        'fault_cause_mandatory',
        'fault_remedy_mandatory',
        'fault_symptom_mandatory',
        'production_stop_mandatory',
        'schedule_one_worker',
        'am_cost_type_id',
        'am_work_order_lifecycle_model_id',
        'tenant_id',
    ];

    protected $casts = [
        'fault_cause_mandatory' => 'boolean',
        'fault_remedy_mandatory' => 'boolean',
        'fault_symptom_mandatory' => 'boolean',
        'production_stop_mandatory' => 'boolean',
        'schedule_one_worker' => 'boolean',
    ];

    /**
     * Get the tenant that owns the work order type.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the cost type for this work order type.
     */
    public function costType(): BelongsTo
    {
        return $this->belongsTo(AMCostType::class, 'am_cost_type_id');
    }

    /**
     * Get the work order lifecycle model for this work order type.
     */
    public function workOrderLifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmWorkOrderLifecycleModel::class, 'am_work_order_lifecycle_model_id');
    }
}
