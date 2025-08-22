<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('am_work_order_lifecycle_states', function (Blueprint $table) {
            $table->id();
            $table->string('lifecycle_state')->index();
            $table->string('name');
            $table->boolean('close_activities')->default(false);
            $table->boolean('copy_forecast_expense')->default(false);
            $table->boolean('copy_forecast_hour')->default(false);
            $table->boolean('copy_forecast_item')->default(false);
            $table->foreignId('maintenance_asset_lifecycle_state_id')->nullable();
            $table->boolean('maintenance_plan_counter_reset')->default(false);
            $table->boolean('post_work_order_journals')->default(false);
            $table->string('project_status')->nullable();
            $table->string('request_lifecycle_state_id')->nullable();
            $table->boolean('schedule_end')->default(false);
            $table->boolean('schedule_ready')->default(false);
            $table->boolean('schedule_start')->default(false);
            $table->boolean('update_maintenance_asset_bom')->default(false);
            $table->boolean('validate_committed_cost')->default(false);
            $table->string('validate_committed_cost_info_type')->nullable();
            $table->boolean('validate_fault_cause')->default(false);
            $table->string('validate_fault_cause_info_type')->nullable();
            $table->boolean('validate_fault_remedy')->default(false);
            $table->string('validate_fault_remedy_info_type')->nullable();
            $table->boolean('validate_fault_symptom')->default(false);
            $table->string('validate_fault_symptom_info_type')->nullable();
            $table->boolean('validate_production_stop')->default(false);
            $table->string('validate_production_stop_info_type')->nullable();
            $table->boolean('work_order_active')->default(false);
            $table->boolean('work_order_allow_delete')->default(false);
            $table->boolean('work_order_allow_line_delete')->default(false);
            $table->boolean('work_order_allow_scheduling')->default(false);
            $table->boolean('work_order_create_job')->default(false);
            $table->boolean('work_order_line_schedule_delete')->default(false);
            $table->boolean('work_order_pool_delete')->default(false);
            $table->boolean('work_order_set_actual_end')->default(false);
            $table->string('work_order_set_actual_end_default')->nullable();
            $table->boolean('work_order_set_actual_start')->default(false);
            $table->string('work_order_set_actual_start_default')->nullable();
            $table->boolean('work_order_validate_checklist')->default(false);
            $table->string('work_order_validate_checklist_info_type')->nullable();
            $table->foreignId('lifecycle_model_id')->references('id')->on('am_work_order_lifecycle_models')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique lifecycle state per tenant
            $table->unique(['lifecycle_state', 'tenant_id'], 'unique_work_order_lifecycle_state_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_work_order_lifecycle_states');
    }
};
