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
        Schema::table('am_maintenance_job_types', function (Blueprint $table) {
            $table->boolean('maintenance_stop_required')->default(false)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_maintenance_job_types', function (Blueprint $table) {
            $table->dropColumn('maintenance_stop_required');
        });
    }
};
