<?php

namespace Database\Seeders;

use App\Models\AMMaintenanceJobTypeCategory;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMMaintenanceJobTypeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Job type categories based on the screenshot provided
        $jobTypeCategories = [
            ['job_type_category_code' => 'CORRECTIVE', 'name' => 'Corrective Maintenance', 'description' => 'Maintenance performed to correct a fault or defect'],
            ['job_type_category_code' => 'PREVENTIVE', 'name' => 'Preventive Maintenance', 'description' => 'Scheduled maintenance to prevent equipment failure'],
            ['job_type_category_code' => 'PREDICTIVE', 'name' => 'Predictive Maintenance', 'description' => 'Maintenance based on condition monitoring and analysis'],
            ['job_type_category_code' => 'EMERGENCY', 'name' => 'Emergency Maintenance', 'description' => 'Urgent maintenance to restore critical equipment'],
            ['job_type_category_code' => 'INSPECTION', 'name' => 'Inspection', 'description' => 'Regular inspections and assessments'],
            ['job_type_category_code' => 'CALIBRATION', 'name' => 'Calibration', 'description' => 'Equipment calibration and adjustment'],
            ['job_type_category_code' => 'REPAIR', 'name' => 'Repair', 'description' => 'General repair and restoration work'],
            ['job_type_category_code' => 'REPLACEMENT', 'name' => 'Replacement', 'description' => 'Component or equipment replacement'],
            ['job_type_category_code' => 'CLEANING', 'name' => 'Cleaning', 'description' => 'Equipment cleaning and maintenance'],
            ['job_type_category_code' => 'LUBRICATION', 'name' => 'Lubrication', 'description' => 'Equipment lubrication and greasing'],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($jobTypeCategories as $jobTypeCategory) {
                // Check if this job type category already exists for this tenant
                $existingJobTypeCategory = AMMaintenanceJobTypeCategory::where('tenant_id', $tenant->id)
                    ->where('job_type_category_code', $jobTypeCategory['job_type_category_code'])
                    ->first();

                if (!$existingJobTypeCategory) {
                    AMMaintenanceJobTypeCategory::create([
                        'job_type_category_code' => $jobTypeCategory['job_type_category_code'],
                        'name' => $jobTypeCategory['name'],
                        'description' => $jobTypeCategory['description'],
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
} 