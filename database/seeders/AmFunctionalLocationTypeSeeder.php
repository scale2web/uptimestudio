<?php

namespace Database\Seeders;

use App\Models\AmFunctionalLocationType;
use App\Models\AmAssetLifecycleModel;
use App\Models\AmAssetType;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmFunctionalLocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Functional location types based on the screenshot provided
        $functionalLocationTypes = [
            [
                'functional_location_type' => 'Area',
                'name' => 'Area',
                'allow_multiple_installed_assets' => true,
                'update_asset_dimension' => true,
                'asset_type_code' => 'Area', // Will be mapped to asset type
            ],
            [
                'functional_location_type' => 'Plant',
                'name' => 'Plant',
                'allow_multiple_installed_assets' => false,
                'update_asset_dimension' => true,
                'asset_type_code' => null, // No specific asset type
            ],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Get the first asset lifecycle model for this tenant
            $assetLifecycleModel = AmAssetLifecycleModel::where('tenant_id', $tenant->id)->first();

            if (!$assetLifecycleModel) {
                // If no asset lifecycle model exists, skip this tenant
                continue;
            }

            foreach ($functionalLocationTypes as $functionalLocationType) {
                // Check if this functional location type already exists for this tenant
                $existingType = AmFunctionalLocationType::where('tenant_id', $tenant->id)
                    ->where('functional_location_type', $functionalLocationType['functional_location_type'])
                    ->first();

                if (!$existingType) {
                    // Find the asset type if specified
                    $assetTypeId = null;
                    if ($functionalLocationType['asset_type_code']) {
                        $assetType = AmAssetType::where('tenant_id', $tenant->id)
                            ->where('maintenance_asset_type', $functionalLocationType['asset_type_code'])
                            ->first();
                        $assetTypeId = $assetType?->id;
                    }

                    AmFunctionalLocationType::create([
                        'functional_location_type' => $functionalLocationType['functional_location_type'],
                        'name' => $functionalLocationType['name'],
                        'allow_multiple_installed_assets' => $functionalLocationType['allow_multiple_installed_assets'],
                        'update_asset_dimension' => $functionalLocationType['update_asset_dimension'],
                        'am_asset_lifecycle_model_id' => $assetLifecycleModel->id,
                        'am_asset_type_id' => $assetTypeId,
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
}
