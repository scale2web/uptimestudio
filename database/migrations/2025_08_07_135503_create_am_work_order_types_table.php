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
        Schema::create('am_work_order_types', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_type')->index();
            $table->string('name');
            $table->boolean('fault_cause_mandatory')->default(false);
            $table->boolean('fault_remedy_mandatory')->default(false);
            $table->boolean('fault_symptom_mandatory')->default(false);
            $table->boolean('production_stop_mandatory')->default(false);
            $table->boolean('schedule_one_worker')->default(false);
            $table->foreignId('am_cost_type_id')->constrained('am_cost_types')->onDelete('cascade');
            $table->foreignId('am_work_order_lifecycle_model_id')->constrained('am_work_order_lifecycle_models')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique work order type per tenant
            $table->unique(['work_order_type', 'tenant_id'], 'unique_work_order_type_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_work_order_types');
    }
};
