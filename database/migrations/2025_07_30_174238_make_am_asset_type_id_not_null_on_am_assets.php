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
        Schema::table('am_assets', function (Blueprint $table) {
            // Make am_asset_type_id not null
            $table->foreignId('am_asset_type_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_assets', function (Blueprint $table) {
            // Revert am_asset_type_id back to nullable
            $table->foreignId('am_asset_type_id')->nullable()->change();
        });
    }
};
