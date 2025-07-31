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
        DB::table('am_assets')->update(['tenant_id' => 61]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: We can't easily reverse this without knowing the original tenant_id values
        // This would need to be handled manually if rollback is required
    }
};
