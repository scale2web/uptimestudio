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
        Schema::create('am_assets', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_asset')->unique();
            $table->decimal('acquisition_cost', 16, 6)->nullable();
            $table->dateTime('acquisition_date')->nullable();
            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();
            $table->decimal('default_dimension_display_value', 16, 6)->nullable();
            $table->string('fixed_asset_id')->nullable();
            $table->string('am_functional_location_id')->nullable();
            $table->string('logistics_location_id')->nullable();
            $table->foreignId('am_asset_lifecycle_state_id')->nullable()->constrained();
            $table->foreignId('am_asset_type_id')->nullable()->constrained();
            $table->string('model_id')->nullable();
            $table->string('model_product_id')->nullable();
            $table->string('model_year')->nullable();
            $table->string('name')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('parent_maintenance_asset_id')->nullable()->constrained('am_assets');
            $table->string('product_id')->nullable();
            $table->string('purchase_order_id')->nullable();
            $table->dateTime('replacement_date')->nullable();
            $table->decimal('replacement_value', 16, 6)->nullable();
            $table->string('serial_id')->nullable();
            $table->string('vend_account')->nullable();
            $table->dateTime('warranty_date_from_vend')->nullable();
            $table->string('warranty_id')->nullable();
            $table->string('wrk_ctr_id')->nullable();
            $table->foreignId('tenant_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_assets');
    }
};
