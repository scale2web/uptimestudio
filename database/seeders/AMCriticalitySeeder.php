<?php

namespace Database\Seeders;

use App\Models\AMCriticality;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMCriticalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criticalityData = [
            [
                'criticality' => 3,
                'name' => 'Low',
                'rating_factor' => 10,
            ],
            [
                'criticality' => 5,
                'name' => 'Medium',
                'rating_factor' => 60,
            ],
            [
                'criticality' => 8,
                'name' => 'High',
                'rating_factor' => 110,
            ],
        ];

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($criticalityData as $data) {
                AMCriticality::firstOrCreate([
                    'criticality' => $data['criticality'],
                    'tenant_id' => $tenant->id,
                ], [
                    'name' => $data['name'],
                    'rating_factor' => $data['rating_factor'],
                ]);
            }
        }
    }
}
