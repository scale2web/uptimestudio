<?php

namespace Database\Seeders;

use App\Models\AmAssetLifecycleModel;
use App\Models\AmAssetLifecycleState;
use App\Models\AmAssetLifecycleStateSequence;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class AmAssetLifecycleStateSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Get the lifecycle models and states for this tenant
            $lifecycleModels = AmAssetLifecycleModel::where('tenant_id', $tenant->id)->get();
            $lifecycleStates = AmAssetLifecycleState::where('tenant_id', $tenant->id)->get();

            if ($lifecycleModels->isEmpty() || $lifecycleStates->isEmpty()) {
                continue;
            }

            foreach ($lifecycleModels as $model) {
                // Define different sequences based on model type
                $sequences = match ($model->lifecycle_model_name) {
                    'STANDARD' => [
                        ['state' => 'NEW', 'line' => 1],
                        ['state' => 'ACT', 'line' => 2],
                        ['state' => 'MNT', 'line' => 3],
                        ['state' => 'INA', 'line' => 4],
                        ['state' => 'DIS', 'line' => 5],
                    ],
                    'CRITICAL' => [
                        ['state' => 'NEW', 'line' => 1],
                        ['state' => 'ACT', 'line' => 2],
                        ['state' => 'MNT', 'line' => 3],
                        ['state' => 'INA', 'line' => 4],
                    ],
                    'SIMPLE' => [
                        ['state' => 'NEW', 'line' => 1],
                        ['state' => 'ACT', 'line' => 2],
                        ['state' => 'DIS', 'line' => 3],
                    ],
                    default => [
                        ['state' => 'NEW', 'line' => 1],
                        ['state' => 'ACT', 'line' => 2],
                        ['state' => 'INA', 'line' => 3],
                    ],
                };

                foreach ($sequences as $sequence) {
                    $state = $lifecycleStates->firstWhere('lifecycle_state', $sequence['state']);

                    if ($state) {
                        AmAssetLifecycleStateSequence::firstOrCreate([
                            'tenant_id' => $tenant->id,
                            'lifecycle_model_id' => $model->id,
                            'lifecycle_state_id' => $state->id,
                            'line' => $sequence['line'],
                        ]);
                    }
                }
            }
        }
    }
}
