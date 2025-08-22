<?php

namespace Database\Seeders;

use App\Models\AMMaintenanceJobType;
use App\Models\AMMaintenanceJobTypeCategory;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMMaintenanceJobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Job types based on the screenshot provided
        $jobTypes = [
            // Corrective Maintenance
            ['job_type_code' => 'CORR001', 'name' => 'Emergency Repair', 'description' => 'Urgent repairs to restore equipment functionality', 'category_code' => 'CORRECTIVE', 'maintenance_stop_required' => true],
            ['job_type_code' => 'CORR002', 'name' => 'Breakdown Repair', 'description' => 'Repairs after equipment failure', 'category_code' => 'CORRECTIVE', 'maintenance_stop_required' => true],
            ['job_type_code' => 'CORR003', 'name' => 'Fault Correction', 'description' => 'Fixing identified faults and defects', 'category_code' => 'CORRECTIVE', 'maintenance_stop_required' => false],
            
            // Preventive Maintenance
            ['job_type_code' => 'PREV001', 'name' => 'Scheduled Inspection', 'description' => 'Regular scheduled inspections', 'category_code' => 'PREVENTIVE', 'maintenance_stop_required' => false],
            ['job_type_code' => 'PREV002', 'name' => 'Preventive Service', 'description' => 'Routine maintenance to prevent failures', 'category_code' => 'PREVENTIVE', 'maintenance_stop_required' => false],
            ['job_type_code' => 'PREV003', 'name' => 'Component Replacement', 'description' => 'Scheduled replacement of components', 'category_code' => 'PREVENTIVE', 'maintenance_stop_required' => true],
            
            // Predictive Maintenance
            ['job_type_code' => 'PRED001', 'name' => 'Condition Monitoring', 'description' => 'Monitoring equipment condition', 'category_code' => 'PREDICTIVE', 'maintenance_stop_required' => false],
            ['job_type_code' => 'PRED002', 'name' => 'Vibration Analysis', 'description' => 'Analyzing vibration patterns', 'category_code' => 'PREDICTIVE', 'maintenance_stop_required' => false],
            ['job_type_code' => 'PRED003', 'name' => 'Thermal Imaging', 'description' => 'Thermal analysis of equipment', 'category_code' => 'PREDICTIVE', 'maintenance_stop_required' => false],
            
            // Emergency Maintenance
            ['job_type_code' => 'EMER001', 'name' => 'Critical Repair', 'description' => 'Emergency critical repairs', 'category_code' => 'EMERGENCY', 'maintenance_stop_required' => true],
            ['job_type_code' => 'EMER002', 'name' => 'Safety Repair', 'description' => 'Safety-related emergency repairs', 'category_code' => 'EMERGENCY', 'maintenance_stop_required' => true],
            
            // Inspection
            ['job_type_code' => 'INSP001', 'name' => 'Visual Inspection', 'description' => 'Visual examination of equipment', 'category_code' => 'INSPECTION', 'maintenance_stop_required' => false],
            ['job_type_code' => 'INSP002', 'name' => 'Detailed Inspection', 'description' => 'Comprehensive equipment inspection', 'category_code' => 'INSPECTION', 'maintenance_stop_required' => false],
            
            // Calibration
            ['job_type_code' => 'CALI001', 'name' => 'Equipment Calibration', 'description' => 'Calibrating measurement equipment', 'category_code' => 'CALIBRATION', 'maintenance_stop_required' => true],
            ['job_type_code' => 'CALI002', 'name' => 'Sensor Calibration', 'description' => 'Calibrating sensors and instruments', 'category_code' => 'CALIBRATION', 'maintenance_stop_required' => true],
            
            // Repair
            ['job_type_code' => 'REPA001', 'name' => 'Component Repair', 'description' => 'Repairing damaged components', 'category_code' => 'REPAIR', 'maintenance_stop_required' => true],
            ['job_type_code' => 'REPA002', 'name' => 'System Repair', 'description' => 'Repairing system issues', 'category_code' => 'REPAIR', 'maintenance_stop_required' => true],
            
            // Replacement
            ['job_type_code' => 'REPL001', 'name' => 'Part Replacement', 'description' => 'Replacing worn or damaged parts', 'category_code' => 'REPLACEMENT', 'maintenance_stop_required' => true],
            ['job_type_code' => 'REPL002', 'name' => 'Equipment Replacement', 'description' => 'Replacing entire equipment units', 'category_code' => 'REPLACEMENT', 'maintenance_stop_required' => true],
            
            // Cleaning
            ['job_type_code' => 'CLEA001', 'name' => 'Equipment Cleaning', 'description' => 'Cleaning equipment surfaces', 'category_code' => 'CLEANING', 'maintenance_stop_required' => false],
            ['job_type_code' => 'CLEA002', 'name' => 'System Cleaning', 'description' => 'Cleaning internal systems', 'category_code' => 'CLEANING', 'maintenance_stop_required' => false],
            
            // Lubrication
            ['job_type_code' => 'LUBR001', 'name' => 'Greasing', 'description' => 'Applying grease to moving parts', 'category_code' => 'LUBRICATION', 'maintenance_stop_required' => false],
            ['job_type_code' => 'LUBR002', 'name' => 'Oil Change', 'description' => 'Changing lubricating oil', 'category_code' => 'LUBRICATION', 'maintenance_stop_required' => false],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($jobTypes as $jobType) {
                // Get the job type category for this tenant
                $jobTypeCategory = AMMaintenanceJobTypeCategory::where('tenant_id', $tenant->id)
                    ->where('job_type_category_code', $jobType['category_code'])
                    ->first();

                if (!$jobTypeCategory) {
                    // Skip if category doesn't exist for this tenant
                    continue;
                }

                // Check if this job type already exists for this tenant
                $existingJobType = AMMaintenanceJobType::where('tenant_id', $tenant->id)
                    ->where('job_type_code', $jobType['job_type_code'])
                    ->first();

                if (!$existingJobType) {
                    AMMaintenanceJobType::create([
                        'job_type_code' => $jobType['job_type_code'],
                        'name' => $jobType['name'],
                        'description' => $jobType['description'],
                        'maintenance_stop_required' => $jobType['maintenance_stop_required'],
                        'job_type_category_id' => $jobTypeCategory->id,
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
} 