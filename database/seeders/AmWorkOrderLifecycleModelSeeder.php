<?php

namespace Database\Seeders;

use App\Models\AmWorkOrderLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmWorkOrderLifecycleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lifecycleModels = [
            [
                'lifecycle_model_name' => 'Standard',
                'name' => 'Standard Work Order Lifecycle',
            ],
        ];

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($lifecycleModels as $lifecycleModel) {
                $existingModel = AmWorkOrderLifecycleModel::where('tenant_id', $tenant->id)
                    ->where('lifecycle_model_name', $lifecycleModel['lifecycle_model_name'])
                    ->first();

                if (!$existingModel) {
                    AmWorkOrderLifecycleModel::create([
                        'lifecycle_model_name' => $lifecycleModel['lifecycle_model_name'],
                        'name' => $lifecycleModel['name'],
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
} 