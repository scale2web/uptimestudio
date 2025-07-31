<?php

namespace Database\Seeders;

use App\Models\AmFunctionalLocationLifecycleModel;
use App\Models\AmFunctionalLocationLifecycleState;
use App\Models\AmFunctionalLocationLifecycleStateSequence;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmFunctionalLocationLifecycleStateSequenceSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $tenants = Tenant::all();
        $totalSequences = 0;

        foreach ($tenants as $tenant) {
            // Get lifecycle models for this tenant
            $lifecycleModels = AmFunctionalLocationLifecycleModel::where('tenant_id', $tenant->id)->get();

            // Get lifecycle states for this tenant  
            $lifecycleStates = AmFunctionalLocationLifecycleState::where('tenant_id', $tenant->id)->get();

            // Create sequences for each model
            foreach ($lifecycleModels as $model) {
                $line = 1;

                // Assign all lifecycle states to each model in sequence
                foreach ($lifecycleStates as $state) {
                    AmFunctionalLocationLifecycleStateSequence::create([
                        'lifecycle_model_id' => $model->id,
                        'lifecycle_state_id' => $state->id,
                        'line' => $line,
                        'tenant_id' => $tenant->id,
                    ]);

                    $line++;
                    $totalSequences++;
                }
            }
        }

        $this->command->info('Created ' . $totalSequences . ' AM Functional Location Lifecycle State Sequences');
    }
}
