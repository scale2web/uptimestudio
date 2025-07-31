<?php

namespace Database\Seeders;

use App\Models\AmAssetLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class AmAssetLifecycleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Create standard asset lifecycle models for each tenant
            $models = [
                [
                    'lifecycle_model_name' => 'STANDARD',
                    'name' => 'Standard Asset Lifecycle',
                ],
                [
                    'lifecycle_model_name' => 'CRITICAL',
                    'name' => 'Critical Asset Lifecycle',
                ],
                [
                    'lifecycle_model_name' => 'SIMPLE',
                    'name' => 'Simple Asset Lifecycle',
                ],
            ];

            foreach ($models as $model) {
                AmAssetLifecycleModel::firstOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_name' => $model['lifecycle_model_name'],
                    ],
                    $model + ['tenant_id' => $tenant->id]
                );
            }
        }
    }
}
