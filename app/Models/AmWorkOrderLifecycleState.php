<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmWorkOrderLifecycleState extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_state',
        'name',
        'close_activities',
        'copy_forecast_expense',
        'copy_forecast_hour',
        'copy_forecast_item',
        'maintenance_asset_lifecycle_state_id',
        'maintenance_plan_counter_reset',
        'post_work_order_journals',
        'project_status',
        'request_lifecycle_state_id',
        'schedule_end',
        'schedule_ready',
        'schedule_start',
        'update_maintenance_asset_bom',
        'validate_committed_cost',
        'validate_committed_cost_info_type',
        'validate_fault_cause',
        'validate_fault_cause_info_type',
        'validate_fault_remedy',
        'validate_fault_remedy_info_type',
        'validate_fault_symptom',
        'validate_fault_symptom_info_type',
        'validate_production_stop',
        'validate_production_stop_info_type',
        'work_order_active',
        'work_order_allow_delete',
        'work_order_allow_line_delete',
        'work_order_allow_scheduling',
        'work_order_create_job',
        'work_order_line_schedule_delete',
        'work_order_pool_delete',
        'work_order_set_actual_end',
        'work_order_set_actual_end_default',
        'work_order_set_actual_start',
        'work_order_set_actual_start_default',
        'work_order_validate_checklist',
        'work_order_validate_checklist_info_type',
        'lifecycle_model_id',
        'tenant_id',
    ];

    protected $casts = [
        'close_activities' => 'boolean',
        'copy_forecast_expense' => 'boolean',
        'copy_forecast_hour' => 'boolean',
        'copy_forecast_item' => 'boolean',
        'maintenance_plan_counter_reset' => 'boolean',
        'post_work_order_journals' => 'boolean',
        'schedule_end' => 'boolean',
        'schedule_ready' => 'boolean',
        'schedule_start' => 'boolean',
        'update_maintenance_asset_bom' => 'boolean',
        'validate_committed_cost' => 'boolean',
        'validate_fault_cause' => 'boolean',
        'validate_fault_remedy' => 'boolean',
        'validate_fault_symptom' => 'boolean',
        'validate_production_stop' => 'boolean',
        'work_order_active' => 'boolean',
        'work_order_allow_delete' => 'boolean',
        'work_order_allow_line_delete' => 'boolean',
        'work_order_allow_scheduling' => 'boolean',
        'work_order_create_job' => 'boolean',
        'work_order_line_schedule_delete' => 'boolean',
        'work_order_pool_delete' => 'boolean',
        'work_order_set_actual_end' => 'boolean',
        'work_order_set_actual_end_default' => 'boolean',
        'work_order_set_actual_start' => 'boolean',
        'work_order_set_actual_start_default' => 'boolean',
        'work_order_validate_checklist' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmWorkOrderLifecycleModel::class, 'lifecycle_model_id');
    }

    public function sequences(): HasMany
    {
        return $this->hasMany(AmWorkOrderLifecycleStateSequence::class, 'lifecycle_state_id');
    }
} 