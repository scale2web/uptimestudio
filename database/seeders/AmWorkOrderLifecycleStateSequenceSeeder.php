<?php

namespace Database\Seeders;

use App\Models\AmWorkOrderLifecycleModel;
use App\Models\AmWorkOrderLifecycleState;
use App\Models\AmWorkOrderLifecycleStateSequence;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmWorkOrderLifecycleStateSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Get the lifecycle model for this tenant
            $lifecycleModel = AmWorkOrderLifecycleModel::where('tenant_id', $tenant->id)
                ->where('lifecycle_model_name', 'Standard')
                ->first();

            if (!$lifecycleModel) {
                continue;
            }

            // Define the sequence order for work order lifecycle states
            $sequenceOrder = [
                'New' => 1,
                'Pending' => 2,
                'Released' => 3,
                'Scheduled' => 4,
                'InProgress' => 5,
                'Completed' => 6,
                'Finished' => 7,
            ];

            foreach ($sequenceOrder as $stateName => $line) {
                // Get the lifecycle state for this tenant
                $lifecycleState = AmWorkOrderLifecycleState::where('tenant_id', $tenant->id)
                    ->where('lifecycle_state', $stateName)
                    ->first();

                if (!$lifecycleState) {
                    continue;
                }

                // Check if this sequence already exists
                $existingSequence = AmWorkOrderLifecycleStateSequence::where('tenant_id', $tenant->id)
                    ->where('lifecycle_model_id', $lifecycleModel->id)
                    ->where('line', $line)
                    ->first();

                if (!$existingSequence) {
                    AmWorkOrderLifecycleStateSequence::create([
                        'lifecycle_model_id' => $lifecycleModel->id,
                        'lifecycle_state_id' => $lifecycleState->id,
                        'line' => $line,
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
} 