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
        Schema::create('am_functional_location_lifecycle_models', function (Blueprint $table) {
            $table->id();
            $table->string('lifecycle_model_name');
            $table->string('name');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->timestamps();

            // Add unique constraint for lifecycle_model_name per tenant
            $table->unique(['tenant_id', 'lifecycle_model_name'], 'am_fl_lifecycle_models_tenant_name_unique');

            // Add index for better query performance
            $table->index(['tenant_id', 'lifecycle_model_name'], 'am_fl_lifecycle_models_tenant_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_functional_location_lifecycle_models');
    }
};
