<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('am_work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_id');
            $table->boolean('active')->default(true);
            $table->dateTime('actual_end')->nullable();
            $table->dateTime('actual_start')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('expected_end')->nullable();
            $table->dateTime('expected_start')->nullable();
            $table->boolean('is_work_order_scheduled_for_single_worker')->default(false);
            $table->string('order_billing_customer_account_number')->nullable();
            $table->string('order_project_contract_id')->nullable();
            $table->dateTime('scheduled_end')->nullable();
            $table->dateTime('scheduled_start')->nullable();
            
            // Foreign key relationships
            $table->foreignId('am_cost_type_id')->nullable()->constrained('am_cost_types')->onDelete('set null');
            $table->foreignId('next_work_order_lifecycle_state_id')->nullable()->constrained('am_work_order_lifecycle_states')->onDelete('set null');
            $table->foreignId('parent_work_order_id')->nullable()->constrained('am_work_orders')->onDelete('set null');
            $table->string('responsible_worker_personnel_number')->nullable();
            $table->string('scheduled_worker_personnel_number')->nullable();
            $table->foreignId('am_criticality_id')->nullable()->constrained('a_m_criticalities')->onDelete('set null');
            $table->foreignId('am_worker_group_id')->nullable()->constrained('am_worker_groups')->onDelete('set null');
            $table->foreignId('am_work_order_lifecycle_state_id')->nullable()->constrained('am_work_order_lifecycle_states')->onDelete('set null');
            $table->foreignId('am_work_order_type_id')->nullable()->constrained('am_work_order_types')->onDelete('set null');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['work_order_id', 'tenant_id']);
            $table->index(['active', 'tenant_id']);
            $table->index(['am_work_order_lifecycle_state_id', 'tenant_id']);
            $table->index(['am_work_order_type_id', 'tenant_id']);
            
            // Ensure unique work order ID per tenant
            $table->unique(['work_order_id', 'tenant_id'], 'unique_work_order_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_work_orders');
    }
};
