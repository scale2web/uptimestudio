<?php

namespace Database\Seeders;

use App\Models\AMWorkOrderType;
use App\Models\AMCostType;
use App\Models\AmWorkOrderLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMWorkOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Work order types based on the screenshot provided
        $workOrderTypes = [
            [
                'work_order_type' => 'Corrective',
                'name' => 'Corrective work orders',
                'fault_cause_mandatory' => false,
                'fault_remedy_mandatory' => false,
                'fault_symptom_mandatory' => false,
                'production_stop_mandatory' => false,
                'schedule_one_worker' => false,
                'cost_type_lookup_value' => 'Corrective',
                'lifecycle_model_lookup_value' => 'Standard',
            ],
            [
                'work_order_type' => 'Investment',
                'name' => 'Investment work orders',
                'fault_cause_mandatory' => false,
                'fault_remedy_mandatory' => false,
                'fault_symptom_mandatory' => false,
                'production_stop_mandatory' => false,
                'schedule_one_worker' => false,
                'cost_type_lookup_value' => 'Investment',
                'lifecycle_model_lookup_value' => 'Standard',
            ],
            [
                'work_order_type' => 'Preventive',
                'name' => 'Preventive work orders',
                'fault_cause_mandatory' => false,
                'fault_remedy_mandatory' => false,
                'fault_symptom_mandatory' => false,
                'production_stop_mandatory' => false,
                'schedule_one_worker' => false,
                'cost_type_lookup_value' => 'Preventive',
                'lifecycle_model_lookup_value' => 'Standard',
            ],
            [
                'work_order_type' => 'Round',
                'name' => 'Rounds',
                'fault_cause_mandatory' => false,
                'fault_remedy_mandatory' => false,
                'fault_symptom_mandatory' => false,
                'production_stop_mandatory' => false,
                'schedule_one_worker' => false,
                'cost_type_lookup_value' => 'Preventive',
                'lifecycle_model_lookup_value' => 'Standard',
            ],
            [
                'work_order_type' => 'Safety',
                'name' => 'Safety work orders',
                'fault_cause_mandatory' => false,
                'fault_remedy_mandatory' => false,
                'fault_symptom_mandatory' => false,
                'production_stop_mandatory' => false,
                'schedule_one_worker' => false,
                'cost_type_lookup_value' => 'Corrective',
                'lifecycle_model_lookup_value' => 'Standard',
            ],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($workOrderTypes as $workOrderType) {
                // Lookup cost type
                $costType = AMCostType::where('tenant_id', $tenant->id)
                    ->where('name', $workOrderType['cost_type_lookup_value'])
                    ->first();

                if (!$costType) {
                    continue; // Skip if cost type doesn't exist for this tenant
                }

                // Lookup work order lifecycle model
                $lifecycleModel = AmWorkOrderLifecycleModel::where('tenant_id', $tenant->id)
                    ->where('lifecycle_model_name', $workOrderType['lifecycle_model_lookup_value'])
                    ->first();

                if (!$lifecycleModel) {
                    continue; // Skip if lifecycle model doesn't exist for this tenant
                }

                // Create work order type
                AMWorkOrderType::firstOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'work_order_type' => $workOrderType['work_order_type'],
                    ],
                    [
                        'name' => $workOrderType['name'],
                        'fault_cause_mandatory' => $workOrderType['fault_cause_mandatory'],
                        'fault_remedy_mandatory' => $workOrderType['fault_remedy_mandatory'],
                        'fault_symptom_mandatory' => $workOrderType['fault_symptom_mandatory'],
                        'production_stop_mandatory' => $workOrderType['production_stop_mandatory'],
                        'schedule_one_worker' => $workOrderType['schedule_one_worker'],
                        'am_cost_type_id' => $costType->id,
                        'am_work_order_lifecycle_model_id' => $lifecycleModel->id,
                        'tenant_id' => $tenant->id,
                    ]
                );
            }
        }
    }
}
