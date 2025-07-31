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
        Schema::create('am_asset_types', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_asset_type')->index();
            $table->string('name');
            $table->boolean('calculate_kpi_total')->default(false);
            $table->foreignId('am_asset_lifecycle_model_id')->constrained('am_asset_lifecycle_models')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique asset type per tenant
            $table->unique(['maintenance_asset_type', 'tenant_id'], 'unique_asset_type_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_asset_types');
    }
};
