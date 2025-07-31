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
        Schema::create('am_functional_location_lifecycle_state_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lifecycle_model_id')
                ->constrained('am_functional_location_lifecycle_models', 'id', 'am_fl_seq_model_id_foreign')
                ->onDelete('cascade');
            $table->foreignId('lifecycle_state_id')
                ->constrained('am_functional_location_lifecycle_states', 'id', 'am_fl_seq_state_id_foreign')
                ->onDelete('cascade');
            $table->integer('line')->unsigned();
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();

            // Foreign key constraints with custom names
            $table->foreign('tenant_id', 'am_fl_seq_tenant_id_foreign')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');

            // Unique constraint: one state can only appear once per model
            $table->unique(['lifecycle_model_id', 'lifecycle_state_id'], 'am_fl_seq_model_state_unique');

            // Unique constraint: line number must be unique per model
            $table->unique(['lifecycle_model_id', 'line'], 'am_fl_seq_model_line_unique');

            // Index for better query performance
            $table->index(['tenant_id', 'lifecycle_model_id'], 'am_fl_seq_tenant_model_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_functional_location_lifecycle_state_sequences');
    }
};
