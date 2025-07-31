<?php

namespace Database\Seeders;

use App\Models\AmAssetType;
use App\Models\AmAssetLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmAssetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asset types based on the screenshot provided
        $assetTypes = [
            ['maintenance_asset_type' => 'Area', 'name' => 'Areas', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Articulated Hauler', 'name' => 'Articulated Haulers', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Bulldozer', 'name' => 'Bulldozer', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Car', 'name' => 'Cars', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Car Engine', 'name' => 'Car engines', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Car Gear', 'name' => 'Car gears', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Conveyor', 'name' => 'Conveyor Belts', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Excavator', 'name' => 'Excavators', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Facility', 'name' => 'Facilities', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Fermentation vessel', 'name' => 'Fermentation vessels', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Filtration unit', 'name' => 'Filtration units', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'FORKLIFT', 'name' => 'FORKLIFT', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Kettle', 'name' => 'Kettles', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Lauter tun', 'name' => 'Lauter tun', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Mash mixer', 'name' => 'Mash mixers', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Maturation tank', 'name' => 'Maturation tanks', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Metal detector', 'name' => 'Metal detectors', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Pipe', 'name' => 'Pipes', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Plate heat exchanger', 'name' => 'Plate heat exchangers', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Property', 'name' => 'Properties', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Pump', 'name' => 'Pumps', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'RESIDENTIAL', 'name' => 'RESIDENTIAL HOMES', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Roller mill', 'name' => 'Roller mills', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Truck', 'name' => 'Trucks', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Truck Engine', 'name' => 'Truck engines', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Truck Gear', 'name' => 'Truck gears', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'WATERCOOLER', 'name' => 'WATERCOOLER', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Wheel Loader', 'name' => 'Wheel Loaders', 'calculate_kpi_total' => false],
            ['maintenance_asset_type' => 'Whirlpool separator', 'name' => 'Whirlpool separators', 'calculate_kpi_total' => false],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Get the first asset lifecycle model for this tenant (or create a default one if none exists)
            $assetLifecycleModel = AmAssetLifecycleModel::where('tenant_id', $tenant->id)->first();

            if (!$assetLifecycleModel) {
                // If no asset lifecycle model exists, skip this tenant or create a default one
                // For now, we'll skip to avoid creating incomplete data
                continue;
            }

            foreach ($assetTypes as $assetType) {
                // Check if this asset type already exists for this tenant
                $existingAssetType = AmAssetType::where('tenant_id', $tenant->id)
                    ->where('maintenance_asset_type', $assetType['maintenance_asset_type'])
                    ->first();

                if (!$existingAssetType) {
                    AmAssetType::create([
                        'maintenance_asset_type' => $assetType['maintenance_asset_type'],
                        'name' => $assetType['name'],
                        'calculate_kpi_total' => $assetType['calculate_kpi_total'],
                        'am_asset_lifecycle_model_id' => $assetLifecycleModel->id,
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
}
