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
        Schema::create('am_asset_lifecycle_state_sequences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('lifecycle_model_id')
                ->constrained('am_asset_lifecycle_models')
                ->onDelete('cascade');
            $table->foreignId('lifecycle_state_id')
                ->constrained('am_asset_lifecycle_states')
                ->onDelete('cascade');
            $table->unsignedInteger('line');
            $table->timestamps();

            // Add composite unique constraints with custom names to stay within 64 character limit
            $table->unique(['tenant_id', 'lifecycle_model_id', 'lifecycle_state_id'], 'am_asset_seq_model_state_unique');
            $table->unique(['tenant_id', 'lifecycle_model_id', 'line'], 'am_asset_seq_model_line_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_asset_lifecycle_state_sequences');
    }
};
