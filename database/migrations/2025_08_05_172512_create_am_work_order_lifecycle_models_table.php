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
        Schema::create('am_work_order_lifecycle_models', function (Blueprint $table) {
            $table->id();
            $table->string('lifecycle_model_name')->index();
            $table->string('name');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique lifecycle model name per tenant
            $table->unique(['lifecycle_model_name', 'tenant_id'], 'unique_work_order_lifecycle_model_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_work_order_lifecycle_models');
    }
};
