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
            $table->foreign('am_functional_location_id')
                  ->references('id')
                  ->on('am_functional_locations')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_assets', function (Blueprint $table) {
            $table->dropForeign(['am_functional_location_id']);
        });
    }
};
