<?php

namespace Database\Seeders;

use App\Models\AmAssetLifecycleState;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class AmAssetLifecycleStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Create standard asset lifecycle states for each tenant
            $states = [
                [
                    'lifecycle_state' => 'NEW',
                    'name' => 'New Asset',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_asset' => true,
                    'allow_installation' => true,
                    'allow_removal' => false,
                    'allow_rename_asset' => true,
                    'asset_active' => false,
                ],
                [
                    'lifecycle_state' => 'ACT',
                    'name' => 'Active',
                    'allow_create_maintenance_orders' => true,
                    'allow_create_preventive_orders' => true,
                    'allow_delete_asset' => false,
                    'allow_installation' => false,
                    'allow_removal' => true,
                    'allow_rename_asset' => true,
                    'asset_active' => true,
                ],
                [
                    'lifecycle_state' => 'MNT',
                    'name' => 'Under Maintenance',
                    'allow_create_maintenance_orders' => true,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_asset' => false,
                    'allow_installation' => false,
                    'allow_removal' => false,
                    'allow_rename_asset' => true,
                    'asset_active' => false,
                ],
                [
                    'lifecycle_state' => 'INA',
                    'name' => 'Inactive',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_asset' => false,
                    'allow_installation' => false,
                    'allow_removal' => true,
                    'allow_rename_asset' => true,
                    'asset_active' => false,
                ],
                [
                    'lifecycle_state' => 'DIS',
                    'name' => 'Disposed',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_asset' => true,
                    'allow_installation' => false,
                    'allow_removal' => false,
                    'allow_rename_asset' => false,
                    'asset_active' => false,
                ],
            ];

            foreach ($states as $state) {
                AmAssetLifecycleState::firstOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'lifecycle_state' => $state['lifecycle_state'],
                    ],
                    $state + ['tenant_id' => $tenant->id]
                );
            }
        }
    }
}
