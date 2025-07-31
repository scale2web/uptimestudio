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
        Schema::create('am_asset_lifecycle_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('lifecycle_model_name', 100);
            $table->string('name', 100);
            $table->timestamps();

            // Add unique constraint on tenant_id and lifecycle_model_name
            $table->unique(['tenant_id', 'lifecycle_model_name'], 'am_asset_models_tenant_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_asset_lifecycle_models');
    }
};
