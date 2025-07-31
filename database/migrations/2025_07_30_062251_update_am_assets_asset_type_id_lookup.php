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
        $assets = AMAsset::whereNull('am_asset_type_id')->get();

        foreach ($assets as $asset) {
            // Skip if no tenant is assigned
            if (!$asset->tenant_id) {
                continue;
            }

            // Get all asset types for this tenant
            $assetTypes = AmAssetType::where('tenant_id', $asset->tenant_id)->get();

            // Find matching asset type based on asset type field
            // TODO: Replace 'asset_type_field' with the actual field name that contains asset type information
            // Possible fields to check: name, maintenance_asset, model_id, or a custom field
            $assetTypeField = $asset->name; // Change this to the actual field name
            
            if ($assetTypeField) {
                $matchingAssetType = $assetTypes->first(function ($assetType) use ($assetTypeField) {
                    // Try exact match first
                    if (strcasecmp($assetTypeField, $assetType->maintenance_asset_type) === 0 ||
                        strcasecmp($assetTypeField, $assetType->name) === 0) {
                        return true;
                    }
                    
                    // Try partial match
                    if (stripos($assetTypeField, $assetType->maintenance_asset_type) !== false ||
                        stripos($assetTypeField, $assetType->name) !== false) {
                        return true;
                    }
                    
                    return false;
                });

                if ($matchingAssetType) {
                    $asset->am_asset_type_id = $matchingAssetType->id;
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
        // Clear all asset type assignments
        AMAsset::whereNotNull('am_asset_type_id')->update(['am_asset_type_id' => null]);
    }
};
