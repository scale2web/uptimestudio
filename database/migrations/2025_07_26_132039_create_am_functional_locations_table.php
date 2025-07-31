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
        Schema::create('am_functional_locations', function (Blueprint $table) {
            $table->id();
            $table->string('functional_location')->index();
            $table->string('name');
            $table->unsignedBigInteger('am_parent_functional_location_id')->nullable()->index();
            $table->decimal('default_dimension_display_value', 10, 2)->nullable();
            $table->unsignedBigInteger('am_asset_lifecycle_states_id')->nullable()->index();
            $table->unsignedBigInteger('am_functional_location_types_id')->index();
            $table->string('inventory_location_id')->nullable();
            $table->string('inventory_site_id')->nullable();
            $table->string('logistics_location_id')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('am_parent_functional_location_id')->references('id')->on('am_functional_locations')->onDelete('cascade');
            $table->foreign('am_functional_location_types_id')->references('id')->on('am_functional_location_types')->onDelete('restrict');
            $table->foreign('am_asset_lifecycle_states_id')->references('id')->on('am_functional_location_lifecycle_states')->onDelete('set null');

            // Unique constraint for functional location per tenant
            $table->unique(['functional_location', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_functional_locations');
    }
};
