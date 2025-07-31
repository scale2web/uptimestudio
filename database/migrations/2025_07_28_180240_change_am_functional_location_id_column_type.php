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
            $table->unsignedBigInteger('am_functional_location_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_assets', function (Blueprint $table) {
            $table->string('am_functional_location_id')->change();
        });
    }
};
