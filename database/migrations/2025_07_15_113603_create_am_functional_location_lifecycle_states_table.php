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
        Schema::create('am_functional_location_lifecycle_states', function (Blueprint $table) {
            $table->id();
            $table->string('lifecycle_state');
            $table->string('name');
            $table->boolean('allow_delete_location')->default(false);
            $table->boolean('allow_install_maintenance_assets')->default(false);
            $table->boolean('allow_new_sub_locations')->default(false);
            $table->boolean('allow_rename_location')->default(false);
            $table->boolean('create_location_maintenance_asset')->default(false);
            $table->boolean('functional_location_active')->default(false);
            $table->unsignedBigInteger('maintenance_asset_lifecycle_state_id')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_functional_location_lifecycle_states');
    }
};
