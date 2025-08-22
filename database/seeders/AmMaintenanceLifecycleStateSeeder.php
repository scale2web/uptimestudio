<?php

namespace Database\Seeders;

use App\Models\AmMaintenanceLifecycleState;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class AmMaintenanceLifecycleStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Create standard maintenance lifecycle states for each tenant
            $states = [
                [
                    'lifecycle_state' => 'NEW',
                    'name' => 'New Maintenance Request',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_maintenance_request' => true,
                    'allow_installation' => false,
                    'allow_removal' => false,
                    'allow_rename_maintenance_request' => true,
                    'maintenance_request_active' => false,
                ],
                [
                    'lifecycle_state' => 'ACT',
                    'name' => 'Active Maintenance Request',
                    'allow_create_maintenance_orders' => true,
                    'allow_create_preventive_orders' => true,
                    'allow_delete_maintenance_request' => false,
                    'allow_installation' => true,
                    'allow_removal' => false,
                    'allow_rename_maintenance_request' => true,
                    'maintenance_request_active' => true,
                ],
                [
                    'lifecycle_state' => 'MNT',
                    'name' => 'Under Maintenance',
                    'allow_create_maintenance_orders' => true,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_maintenance_request' => false,
                    'allow_installation' => false,
                    'allow_removal' => false,
                    'allow_rename_maintenance_request' => true,
                    'maintenance_request_active' => false,
                ],
                [
                    'lifecycle_state' => 'INA',
                    'name' => 'Inactive Maintenance Request',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_maintenance_request' => false,
                    'allow_installation' => false,
                    'allow_removal' => true,
                    'allow_rename_maintenance_request' => true,
                    'maintenance_request_active' => false,
                ],
                [
                    'lifecycle_state' => 'COM',
                    'name' => 'Completed Maintenance Request',
                    'allow_create_maintenance_orders' => false,
                    'allow_create_preventive_orders' => false,
                    'allow_delete_maintenance_request' => false,
                    'allow_installation' => false,
                    'allow_removal' => false,
                    'allow_rename_maintenance_request' => false,
                    'maintenance_request_active' => false,
                ],
            ];

            foreach ($states as $state) {
                AmMaintenanceLifecycleState::firstOrCreate(
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
