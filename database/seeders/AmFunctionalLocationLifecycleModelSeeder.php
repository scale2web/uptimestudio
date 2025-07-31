<?php

namespace Database\Seeders;

use App\Models\AmFunctionalLocationLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmFunctionalLocationLifecycleModelSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $models = [
            ['lifecycle_model_name' => 'GLOBAL', 'name' => 'Standard functional location stage group'],
            ['lifecycle_model_name' => 'INDUSTRIAL', 'name' => 'Industrial equipment lifecycle model'],
            ['lifecycle_model_name' => 'FACILITY', 'name' => 'Facility management lifecycle model'],
            ['lifecycle_model_name' => 'INFRASTRUCTURE', 'name' => 'Infrastructure asset lifecycle model'],
        ];

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($models as $model) {
                AmFunctionalLocationLifecycleModel::create([
                    'lifecycle_model_name' => $model['lifecycle_model_name'],
                    'name' => $model['name'],
                    'tenant_id' => $tenant->id,
                ]);
            }
        }

        $this->command->info('Created ' . (count($models) * $tenants->count()) . ' AM Functional Location Lifecycle Models');
    }
}
