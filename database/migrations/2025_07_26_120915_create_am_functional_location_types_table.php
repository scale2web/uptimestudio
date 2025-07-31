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
        Schema::create('am_functional_location_types', function (Blueprint $table) {
            $table->id();
            $table->string('functional_location_type')->index();
            $table->string('name');
            $table->boolean('allow_multiple_installed_assets')->default(false);
            $table->boolean('update_asset_dimension')->default(false);
            $table->foreignId('am_asset_lifecycle_model_id')->constrained('am_asset_lifecycle_models')->onDelete('cascade');
            $table->foreignId('am_asset_type_id')->nullable()->constrained('am_asset_types')->onDelete('set null');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique functional location type per tenant
            $table->unique(['functional_location_type', 'tenant_id'], 'unique_functional_location_type_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_functional_location_types');
    }
};
