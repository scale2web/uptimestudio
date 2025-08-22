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
        Schema::create('am_maintenance_lifecycle_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('lifecycle_state', 20);
            $table->string('name', 100);
            $table->boolean('allow_create_maintenance_orders')->default(true);
            $table->boolean('allow_create_preventive_orders')->default(true);
            $table->boolean('allow_delete_maintenance_request')->default(false);
            $table->boolean('allow_installation')->default(true);
            $table->boolean('allow_removal')->default(false);
            $table->boolean('allow_rename_maintenance_request')->default(true);
            $table->boolean('maintenance_request_active')->default(true);
            $table->timestamps();

            // Add unique constraint on tenant_id and lifecycle_state
            $table->unique(['tenant_id', 'lifecycle_state'], 'am_maintenance_states_tenant_state_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_maintenance_lifecycle_states');
    }
};
