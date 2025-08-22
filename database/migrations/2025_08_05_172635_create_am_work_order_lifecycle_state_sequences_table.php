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
        Schema::create('am_work_order_lifecycle_state_sequences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lifecycle_model_id');
            $table->unsignedBigInteger('lifecycle_state_id');
            $table->integer('line');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure unique sequence per model and line per tenant
            $table->unique(['lifecycle_model_id', 'line', 'tenant_id'], 'unique_work_order_sequence_per_model_line_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_work_order_lifecycle_state_sequences');
    }
};
