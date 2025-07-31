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
        // First, clear all am_asset_type_id on AMAssets
        AMAsset::whereNotNull('am_asset_type_id')->update(['am_asset_type_id' => null]);

        // Define the prefix to asset type mapping
        $prefixMapping = [
            'VE' => 'Vehicle',
            'SCR' => 'Vehicle',
            'FIL-' => 'Filter-Bag',
            'V-' => 'Vessel',
            'PSV-' => 'Relief Device-PSV',
            'SS-' => 'Safety Shower',
            'WB-' => 'Waterbath',
            'FL-' => 'FORKLIFT',
            'METER-NG' => 'Meter-NG',
            'GEN-' => 'Generator',
            'COM-' => 'Air Compressor',
            'METER-H2O' => 'Meter-H2O',
            'H-' => 'Hopper',
            'VP-' => 'Pump-Vacuum',
            'AK-' => 'Air Knife',
            'MI-' => 'Mixer',
            'PX-' => 'Plate heat exchanger',
            'BLN-' => 'Blender',
            'DCD-' => 'Drive-DC',
            'DCM-' => 'Motor-DC',
            'EX-' => 'Extruder',
            'GB-' => 'Extruder',
            'MD-' => 'Metal detector',
            'CL-' => 'Classifier',
        ];

        // Get all AMAssets
        $assets = AMAsset::all();

        foreach ($assets as $asset) {
            // Skip if no tenant is assigned
            if (!$asset->tenant_id) {
                continue;
            }

            $maintenanceAsset = $asset->maintenance_asset;
            if (!$maintenanceAsset) {
                continue;
            }

            // Find matching asset type based on prefix
            $matchingAssetType = null;
            foreach ($prefixMapping as $prefix => $assetTypeName) {
                if (str_starts_with(strtoupper($maintenanceAsset), strtoupper($prefix))) {
                    // Look up the asset type for this tenant
                    $matchingAssetType = AmAssetType::where('tenant_id', $asset->tenant_id)
                        ->where('maintenance_asset_type', $assetTypeName)
                        ->first();
                    break;
                }
            }

            // Update the asset if we found a matching asset type
            if ($matchingAssetType) {
                $asset->am_asset_type_id = $matchingAssetType->id;
                $asset->save();
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
