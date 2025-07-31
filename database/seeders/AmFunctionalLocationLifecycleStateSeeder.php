<?php

namespace Database\Seeders;

use App\Models\AmFunctionalLocationLifecycleState;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmFunctionalLocationLifecycleStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants to seed lifecycle states for each tenant
        $tenants = Tenant::all();

        $lifecycleStates = [
            [
                'lifecycle_state' => 'Active',
                'name' => 'Active functional location, which is currently in service',
                'allow_delete_location' => true,
                'allow_install_maintenance_assets' => true,
                'allow_new_sub_locations' => true,
                'allow_rename_location' => true,
                'create_location_maintenance_asset' => true,
                'functional_location_active' => true,
                'maintenance_asset_lifecycle_state_id' => null,
            ],
            [
                'lifecycle_state' => 'Ended',
                'name' => 'Ended functional location, which has been taken out of service',
                'allow_delete_location' => false,
                'allow_install_maintenance_assets' => false,
                'allow_new_sub_locations' => false,
                'allow_rename_location' => false,
                'create_location_maintenance_asset' => false,
                'functional_location_active' => false,
                'maintenance_asset_lifecycle_state_id' => null,
            ],
            [
                'lifecycle_state' => 'New',
                'name' => 'New functional location, which have not yet been taken into service',
                'allow_delete_location' => true,
                'allow_install_maintenance_assets' => false,
                'allow_new_sub_locations' => true,
                'allow_rename_location' => true,
                'create_location_maintenance_asset' => false,
                'functional_location_active' => false,
                'maintenance_asset_lifecycle_state_id' => null,
            ],
        ];

        foreach ($tenants as $tenant) {
            foreach ($lifecycleStates as $state) {
                AmFunctionalLocationLifecycleState::firstOrCreate(
                    [
                        'lifecycle_state' => $state['lifecycle_state'],
                        'tenant_id' => $tenant->id,
                    ],
                    array_merge($state, ['tenant_id' => $tenant->id])
                );
            }
        }
    }
}
