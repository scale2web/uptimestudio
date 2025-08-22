<?php

namespace Database\Seeders;

use App\Models\AMCostType;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AMCostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $costTypes = [
            'Corrective',
            'Investment', 
            'Preventive',
        ];

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            foreach ($costTypes as $costType) {
                $existingCostType = AMCostType::where('tenant_id', $tenant->id)
                    ->where('name', $costType)
                    ->first();

                if (!$existingCostType) {
                    AMCostType::create([
                        'name' => $costType,
                        'tenant_id' => $tenant->id,
                    ]);
                }
            }
        }
    }
}
