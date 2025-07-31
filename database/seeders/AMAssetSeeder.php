<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AMAsset;
use App\Models\AmAssetType;
use App\Models\AmAssetLifecycleState;
use App\Models\Tenant;

class AMAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = fopen(storage_path('app/seed/Asset management assets.csv'), 'r');
        $header = fgetcsv($csv);
        
        // Remove UTF-8 BOM from column names
        $header = array_map(function($columnName) {
            return ltrim($columnName, "\xEF\xBB\xBF");
        }, $header);
        
        // Create a mapping to handle duplicate columns by taking the first occurrence
        $columnMapping = [];
        $seenColumns = [];
        foreach ($header as $index => $columnName) {
            if (!in_array($columnName, $seenColumns)) {
                $seenColumns[] = $columnName;
                $columnMapping[$columnName] = $index;
            }
        }

        $assets = [];
        $rowCount = 0;
        while ($row = fgetcsv($csv)) {
            $rowCount++;
            
            // Debug first row
            if ($rowCount === 1) {
                echo "First row MaintenanceAsset value: " . ($row[$columnMapping['MaintenanceAsset']] ?? 'NOT FOUND') . "\n";
            }

            $maintenanceAsset = $row[$columnMapping['MaintenanceAsset']] ?? null;
            if (!$maintenanceAsset) {
                echo "ERROR: MaintenanceAsset not found in row $rowCount\n";
                continue;
            }

            $assetType = AmAssetType::where('name', $row[$columnMapping['am_asset_type_id']] ?? '')->first();
            $lifecycleState = AmAssetLifecycleState::where('name', $row[$columnMapping['am_asset_lifecycle_state_id']] ?? '')->first();
            $tenant = Tenant::first(); // Or lookup by name if available

            // Helper function to handle empty values for decimal fields
            $getDecimalValue = function($value) {
                return !empty($value) && $value !== '.000000' ? $value : null;
            };

            // Helper function to handle empty values for date fields
            $getDateValue = function($value) {
                return !empty($value) && $value !== '1900-01-01 00:00:00' ? $value : null;
            };

            $assets[$maintenanceAsset] = AMAsset::create([
                'maintenance_asset' => $maintenanceAsset,
                'acquisition_cost' => $getDecimalValue($row[$columnMapping['AcquisitionCost']] ?? ''),
                'acquisition_date' => $getDateValue($row[$columnMapping['AcquisitionDate']] ?? ''),
                'active_from' => $getDateValue($row[$columnMapping['ActiveFrom']] ?? ''),
                'active_to' => $getDateValue($row[$columnMapping['ActiveTo']] ?? ''),
                'default_dimension_display_value' => $getDecimalValue($row[$columnMapping['DefaultDimensionDisplayValue']] ?? ''),
                'fixed_asset_id' => $row[$columnMapping['FixedAssetId']] ?? null,
                'am_functional_location_id' => $row[$columnMapping['am_functional_location_id']] ?? null,
                'logistics_location_id' => $row[$columnMapping['LogisticsLocationId']] ?? null,
                'am_asset_lifecycle_state_id' => $lifecycleState?->id,
                'am_asset_type_id' => $assetType?->id,
                'model_id' => $row[$columnMapping['ModelId']] ?? null,
                'model_product_id' => $row[$columnMapping['ModelProductId']] ?? null,
                'model_year' => $row[$columnMapping['ModelYear']] ?? null,
                'name' => $row[$columnMapping['Name']] ?? null,
                'notes' => $row[$columnMapping['Notes']] ?? null,
                'product_id' => $row[$columnMapping['ProductId']] ?? null,
                'purchase_order_id' => $row[$columnMapping['PurchaseOrderId']] ?? null,
                'replacement_date' => $getDateValue($row[$columnMapping['ReplacementDate']] ?? ''),
                'replacement_value' => $getDecimalValue($row[$columnMapping['ReplacementValue']] ?? ''),
                'serial_id' => $row[$columnMapping['SerialId']] ?? null,
                'vend_account' => $row[$columnMapping['VendAccount']] ?? null,
                'warranty_date_from_vend' => $getDateValue($row[$columnMapping['WarrantyDateFromVend']] ?? ''),
                'warranty_id' => $row[$columnMapping['WarrantyId']] ?? null,
                'wrk_ctr_id' => $row[$columnMapping['WrkCtrId']] ?? null,
                'tenant_id' => $tenant?->id,
            ]);
        }

        // Second pass for parent relationships
        rewind($csv);
        fgetcsv($csv); // skip header
        while ($row = fgetcsv($csv)) {
            $maintenanceAsset = $row[$columnMapping['MaintenanceAsset']] ?? null;
            $parentMaintenanceAssetId = $row[$columnMapping['ParentMaintenanceAssetId']] ?? null;
            
            if ($parentMaintenanceAssetId && isset($assets[$maintenanceAsset])) {
                $parent = $assets[$parentMaintenanceAssetId] ?? null;
                if ($parent) {
                    $assets[$maintenanceAsset]->parent_maintenance_asset_id = $parent->id;
                    $assets[$maintenanceAsset]->save();
                }
            }
        }

        fclose($csv);
    }
}
