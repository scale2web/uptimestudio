<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clean up orphaned functional_location_ids
        // Set am_functional_location_id to NULL where the referenced ID doesn't exist in am_functional_locations
        DB::statement("
            UPDATE am_assets 
            SET am_functional_location_id = NULL 
            WHERE am_functional_location_id IS NOT NULL 
            AND am_functional_location_id NOT IN (
                SELECT id FROM am_functional_locations
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We can't easily reverse this without knowing the original functional_location_id values
        // This would need to be handled manually if rollback is required
    }
};
