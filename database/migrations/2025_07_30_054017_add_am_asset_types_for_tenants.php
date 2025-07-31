<?php

use App\Models\AmAssetLifecycleModel;
use App\Models\AmAssetType;
use App\Models\Tenant;
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
        // Get all tenants
        $tenants = Tenant::all();

        // Asset types to create for each tenant
        $assetTypes = [
            'Air Knife',
            'Blender',
            'Classifier',
            'Air Compressor',
            'Drive-DC',
            'Motor-DC',
            'Extruder',
            'Filter-Cartridge',
            'Filter-Bag',
            'Forklift',
            'Gearbox',
            'Generator',
            'Hopper',
            'Metal Detector',
            'Meter-H2O',
            'Meter-NG',
            'Mixer',
            'Relief Device-PSV',
            'Pelletizer',
            'Screw-Extruder',
            'Silo',
            'Safety Shower',
            'Vessel',
            'Vehicle',
            'Pump-Vacuum',
            'Waterbath',
        ];

        foreach ($tenants as $tenant) {
            // Find the STANDARD lifecycle model for this tenant
            $standardLifecycleModel = AmAssetLifecycleModel::where('tenant_id', $tenant->id)
                ->where('lifecycle_model_name', 'STANDARD')
                ->first();

            if (!$standardLifecycleModel) {
                // Skip if no STANDARD lifecycle model exists for this tenant
                continue;
            }

            // Create asset types for this tenant
            foreach ($assetTypes as $assetType) {
                AmAssetType::updateOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'maintenance_asset_type' => $assetType,
                    ],
                    [
                        'name' => $assetType,
                        'calculate_kpi_total' => false,
                        'am_asset_lifecycle_model_id' => $standardLifecycleModel->id,
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        // Asset types to remove
        $assetTypes = [
            'Air Knife',
            'Blender',
            'Classifier',
            'Air Compressor',
            'Drive-DC',
            'Motor-DC',
            'Extruder',
            'Filter-Cartridge',
            'Filter-Bag',
            'Forklift',
            'Gearbox',
            'Generator',
            'Hopper',
            'Metal Detector',
            'Meter-H2O',
            'Meter-NG',
            'Mixer',
            'Relief Device-PSV',
            'Pelletizer',
            'Screw-Extruder',
            'Silo',
            'Safety Shower',
            'Vessel',
            'Vehicle',
            'Pump-Vacuum',
            'Waterbath',
        ];

        foreach ($tenants as $tenant) {
            // Remove asset types for this tenant
            foreach ($assetTypes as $assetType) {
                AmAssetType::where('tenant_id', $tenant->id)
                    ->where('maintenance_asset_type', $assetType)
                    ->delete();
            }
        }
    }
};
