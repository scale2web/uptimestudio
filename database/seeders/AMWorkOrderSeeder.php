<?php

namespace Database\Seeders;

use App\Models\AMWorkOrder;
use App\Models\AMCostType;
use App\Models\AmWorkOrderLifecycleState;
use App\Models\AMWorker;
use App\Models\AMCriticality;
use App\Models\AMWorkerGroup;
use App\Models\AMWorkOrderType;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMWorkOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Get or create required related models for this tenant
            $costType = AMCostType::firstOrCreate(
                ['name' => 'Corrective', 'tenant_id' => $tenant->id],
                ['name' => 'Corrective', 'tenant_id' => $tenant->id]
            );

            $lifecycleStates = [
                'Pending' => AmWorkOrderLifecycleState::firstOrCreate(
                    ['lifecycle_state' => 'Pending', 'tenant_id' => $tenant->id],
                    [
                        'lifecycle_state' => 'Pending',
                        'name' => 'Pending',
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_id' => 1, // Default lifecycle model
                    ]
                ),
                'New' => AmWorkOrderLifecycleState::firstOrCreate(
                    ['lifecycle_state' => 'New', 'tenant_id' => $tenant->id],
                    [
                        'lifecycle_state' => 'New',
                        'name' => 'New',
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_id' => 1, // Default lifecycle model
                    ]
                ),
                'Scheduled' => AmWorkOrderLifecycleState::firstOrCreate(
                    ['lifecycle_state' => 'Scheduled', 'tenant_id' => $tenant->id],
                    [
                        'lifecycle_state' => 'Scheduled',
                        'name' => 'Scheduled',
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_id' => 1, // Default lifecycle model
                    ]
                ),
                'Released' => AmWorkOrderLifecycleState::firstOrCreate(
                    ['lifecycle_state' => 'Released', 'tenant_id' => $tenant->id],
                    [
                        'lifecycle_state' => 'Released',
                        'name' => 'Released',
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_id' => 1, // Default lifecycle model
                    ]
                ),
                'InProgress' => AmWorkOrderLifecycleState::firstOrCreate(
                    ['lifecycle_state' => 'InProgress', 'tenant_id' => $tenant->id],
                    [
                        'lifecycle_state' => 'InProgress',
                        'name' => 'InProgress',
                        'tenant_id' => $tenant->id,
                        'lifecycle_model_id' => 1, // Default lifecycle model
                    ]
                ),
            ];

            $criticality = AMCriticality::firstOrCreate(
                ['criticality' => 2, 'tenant_id' => $tenant->id],
                [
                    'criticality' => 2,
                    'name' => 'Medium',
                    'rating_factor' => 2,
                    'tenant_id' => $tenant->id,
                ]
            );

            $workerGroup = AMWorkerGroup::firstOrCreate(
                ['worker_group' => '4', 'tenant_id' => $tenant->id],
                [
                    'worker_group' => '4',
                    'name' => 'Maintenance Team 4',
                    'tenant_id' => $tenant->id,
                ]
            );

            $workOrderTypes = [
                'Corrective' => AMWorkOrderType::firstOrCreate(
                    ['work_order_type' => 'Corrective', 'tenant_id' => $tenant->id],
                    [
                        'work_order_type' => 'Corrective',
                        'name' => 'Corrective Maintenance',
                        'fault_cause_mandatory' => true,
                        'fault_remedy_mandatory' => true,
                        'fault_symptom_mandatory' => true,
                        'production_stop_mandatory' => false,
                        'schedule_one_worker' => false,
                        'tenant_id' => $tenant->id,
                    ]
                ),
                'Preventive' => AMWorkOrderType::firstOrCreate(
                    ['work_order_type' => 'Preventive', 'tenant_id' => $tenant->id],
                    [
                        'work_order_type' => 'Preventive',
                        'name' => 'Preventive Maintenance',
                        'fault_cause_mandatory' => false,
                        'fault_remedy_mandatory' => false,
                        'fault_symptom_mandatory' => false,
                        'production_stop_mandatory' => false,
                        'schedule_one_worker' => false,
                        'tenant_id' => $tenant->id,
                    ]
                ),
                'Safety' => AMWorkOrderType::firstOrCreate(
                    ['work_order_type' => 'Safety', 'tenant_id' => $tenant->id],
                    [
                        'work_order_type' => 'Safety',
                        'name' => 'Safety Maintenance',
                        'fault_cause_mandatory' => true,
                        'fault_remedy_mandatory' => true,
                        'fault_symptom_mandatory' => true,
                        'production_stop_mandatory' => true,
                        'schedule_one_worker' => false,
                        'tenant_id' => $tenant->id,
                    ]
                ),
            ];

            // Work order data from CSV
            $workOrders = [
                [
                    'work_order_id' => 'WO-000001',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Main motor is emitting a high pitched noise',
                    'expected_end' => '2019-08-17 00:00:00',
                    'expected_start' => '2019-08-15 13:10:40',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['Pending']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Corrective']->id,
                ],
                [
                    'work_order_id' => 'WO-000004',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Extruder Line Weekly PM',
                    'expected_end' => '1900-01-01 00:00:00',
                    'expected_start' => '2019-08-29 07:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['New']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Preventive']->id,
                ],
                [
                    'work_order_id' => 'WO-000005',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Emergency Generator Weekly PM',
                    'expected_end' => '1900-01-01 00:00:00',
                    'expected_start' => '2019-08-15 07:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '2019-08-23 17:37:59',
                    'scheduled_start' => '2019-08-22 22:07:59',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['Scheduled']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Preventive']->id,
                ],
                [
                    'work_order_id' => 'WO-000006',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Emergency Generator Weekly PM',
                    'expected_end' => '1900-01-01 00:00:00',
                    'expected_start' => '2019-08-15 07:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '2019-08-23 22:07:59',
                    'scheduled_start' => '2019-08-23 17:37:59',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['Scheduled']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Preventive']->id,
                ],
                [
                    'work_order_id' => 'WO-000007',
                    'active' => true,
                    'actual_end' => '2019-09-07 00:00:00',
                    'actual_start' => '2019-09-01 00:00:00',
                    'description' => 'Repair coupling cover. It has a dent in it that could interf',
                    'expected_end' => '2019-09-07 00:00:00',
                    'expected_start' => '2019-09-01 00:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['Released']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Corrective']->id,
                ],
                [
                    'work_order_id' => 'WO-000008',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Weld small stress crack on Waterbath 006',
                    'expected_end' => '2019-09-01 00:00:00',
                    'expected_start' => '2019-08-29 00:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['New']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Corrective']->id,
                ],
                [
                    'work_order_id' => 'WO-000011',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '2019-08-20 00:00:00',
                    'description' => 'Line 2 Extruder has a barrel guard coming loose',
                    'expected_end' => '2019-08-27 00:00:00',
                    'expected_start' => '2019-08-20 00:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['InProgress']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Safety']->id,
                ],
                [
                    'work_order_id' => 'WO-000012',
                    'active' => true,
                    'actual_end' => '1900-01-01 00:00:00',
                    'actual_start' => '1900-01-01 00:00:00',
                    'description' => 'Replace Knives on Pelletizer for Line 2',
                    'expected_end' => '2019-09-25 00:00:00',
                    'expected_start' => '2019-09-20 00:00:00',
                    'is_work_order_scheduled_for_single_worker' => false,
                    'scheduled_end' => '1900-01-01 00:00:00',
                    'scheduled_start' => '1900-01-01 00:00:00',
                    'am_cost_type_id' => $costType->id,
                    'am_work_order_lifecycle_state_id' => $lifecycleStates['New']->id,
                    'am_criticality_id' => $criticality->id,
                    'am_worker_group_id' => $workerGroup->id,
                    'am_work_order_type_id' => $workOrderTypes['Corrective']->id,
                ],
            ];

            foreach ($workOrders as $workOrderData) {
                AMWorkOrder::firstOrCreate(
                    ['work_order_id' => $workOrderData['work_order_id'], 'tenant_id' => $tenant->id],
                    array_merge($workOrderData, ['tenant_id' => $tenant->id])
                );
            }
        }
    }
}
