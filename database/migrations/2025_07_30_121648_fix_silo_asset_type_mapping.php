<?php

use App\Models\AMAsset;
use App\Models\AmAssetType;
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
        // Get all AMAssets that don't have an asset type assigned
        $assetsWithoutType = AMAsset::whereNull('am_asset_type_id')->get();

        foreach ($assetsWithoutType as $asset) {
            // Skip if no tenant is assigned
            if (!$asset->tenant_id) {
                continue;
            }

            $maintenanceAsset = $asset->maintenance_asset;
            if (!$maintenanceAsset) {
                continue;
            }

            // Check for SIL- prefix and map to Silo
            if (str_starts_with(strtoupper($maintenanceAsset), 'SIL-')) {
                // Look up the Silo asset type for this tenant
                $siloAssetType = AmAssetType::where('tenant_id', $asset->tenant_id)
                    ->where('maintenance_asset_type', 'Silo')
                    ->first();

                if ($siloAssetType) {
                    $asset->am_asset_type_id = $siloAssetType->id;
                    $asset->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Find assets that were updated by this migration (SIL- prefix)
        $assetsToReset = AMAsset::whereNotNull('am_asset_type_id')
            ->whereHas('assetType', function ($query) {
                $query->where('maintenance_asset_type', 'Silo');
            })
            ->whereRaw('UPPER(maintenance_asset) LIKE ?', ['SIL-%'])
            ->get();

        foreach ($assetsToReset as $asset) {
            $asset->am_asset_type_id = null;
            $asset->save();
        }
    }
};
