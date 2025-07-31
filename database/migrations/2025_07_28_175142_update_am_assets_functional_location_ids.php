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
        // Update am_functional_location_id in am_assets table
        // Join with am_functional_locations table to get the correct ID
        // based on functional_location string and tenant_id
        DB::statement("
            UPDATE am_assets 
            SET am_functional_location_id = (
                SELECT afl.id 
                FROM am_functional_locations afl 
                WHERE afl.functional_location = am_assets.am_functional_location_id 
                AND afl.tenant_id = am_assets.tenant_id
                LIMIT 1
            )
            WHERE am_functional_location_id IS NOT NULL 
            AND am_functional_location_id != ''
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
