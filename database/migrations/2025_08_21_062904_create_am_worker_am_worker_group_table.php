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
        Schema::create('am_worker_am_worker_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('am_worker_id')->constrained('am_workers')->onDelete('cascade');
            $table->foreignId('am_worker_group_id')->constrained('am_worker_groups')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique worker-group combination per tenant
            $table->unique(['am_worker_id', 'am_worker_group_id', 'tenant_id'], 'worker_group_unique');
            
            // Index for better performance
            $table->index(['tenant_id', 'am_worker_id']);
            $table->index(['tenant_id', 'am_worker_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_worker_am_worker_group');
    }
};
