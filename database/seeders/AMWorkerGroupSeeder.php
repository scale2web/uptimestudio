<?php

namespace Database\Seeders;

use App\Models\AMWorkerGroup;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMWorkerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tenants
        $tenants = Tenant::all();
        
        if ($tenants->isEmpty()) {
            $this->command->warn('No tenants found. Skipping worker group seeding.');
            return;
        }
        
        // Data from the screenshot
        $workerGroupsData = [
            ['Electrical', 'Electrical workers'],
            ['Hydraulic', 'Hydraulic workers'],
            ['Mechanical', 'Mechanical workers'],
            ['Pneumatic', 'Pneumatic workers'],
            ['Requests', 'First response workers for requests'],
        ];
        
        foreach ($tenants as $tenant) {
            $this->command->info("Seeding worker groups for tenant: {$tenant->name}");
            
            foreach ($workerGroupsData as $workerGroupData) {
                AMWorkerGroup::firstOrCreate([
                    'worker_group' => $workerGroupData[0],
                    'tenant_id' => $tenant->id,
                ], [
                    'name' => $workerGroupData[1],
                ]);
            }
        }
        
        $this->command->info('Worker groups seeded successfully!');
    }
}
