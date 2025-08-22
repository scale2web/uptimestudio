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
        Schema::create('am_maintenance_job_types', function (Blueprint $table) {
            $table->id();
            $table->string('job_type_code')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('job_type_category_id')->references('id')->on('am_maintenance_job_type_categories')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique job type code per tenant
            $table->unique(['job_type_code', 'tenant_id'], 'unique_job_type_per_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_maintenance_job_types');
    }
};
