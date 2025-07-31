<?php

namespace Database\Seeders;

use App\Models\AmFunctionalLocation;
use App\Models\AmFunctionalLocationType;
use App\Models\AmFunctionalLocationLifecycleState;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmFunctionalLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first tenant for seeding
        $tenant = Tenant::first();

        if (!$tenant) {
            $this->command->warn('No tenant found. Please create a tenant first.');
            return;
        }

        // Get functional location types
        $areaType = AmFunctionalLocationType::where('functional_location_type', 'Area')->first();
        $plantType = AmFunctionalLocationType::where('functional_location_type', 'Plant')->first();

        if (!$areaType || !$plantType) {
            $this->command->warn('Functional location types not found. Please run AmFunctionalLocationTypeSeeder first.');
            return;
        }

        // Get lifecycle state (assuming first one is active)
        $lifecycleState = AmFunctionalLocationLifecycleState::first();

        // Create functional locations based on the screenshot data
        $locations = [
            // Root locations
            [
                'functional_location' => 'DEF',
                'name' => 'Default location',
                'parent' => null,
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP',
                'name' => 'USMF Plastics',
                'parent' => null,
                'type' => $plantType,
            ],

            // PP sub-locations
            [
                'functional_location' => 'PP-01',
                'name' => 'Raw Materials',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02',
                'name' => 'Extrusion Lines',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-01',
                'name' => 'Extrusion Line 1',
                'parent' => 'PP-02',
                'type' => $areaType,
            ],

            // PP-02-01 sub-locations
            [
                'functional_location' => 'PP-02-01-01',
                'name' => 'Cooling/Cutting/Classify Line 1',
                'parent' => 'PP-02-01',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-01-02',
                'name' => 'Vapor and Dust Filtration Line 1',
                'parent' => 'PP-02-01',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-01-03',
                'name' => 'Hoppers for Extrusion Line 1',
                'parent' => 'PP-02-01',
                'type' => $areaType,
            ],

            // PP-02 additional lines
            [
                'functional_location' => 'PP-02-02',
                'name' => 'Extrusion Line 2',
                'parent' => 'PP-02',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-02-01',
                'name' => 'Cooling/Cutting/Classify Line 2',
                'parent' => 'PP-02-02',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-02-02',
                'name' => 'Vapor and Dust Filtration Line 2',
                'parent' => 'PP-02-02',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-02-03',
                'name' => 'Hoppers for Extrusion Line 2',
                'parent' => 'PP-02-02',
                'type' => $areaType,
            ],

            // PP-02-03 line
            [
                'functional_location' => 'PP-02-03',
                'name' => 'Extrusion Line 3',
                'parent' => 'PP-02',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-01',
                'name' => 'Cooling/Cutting/Classify Line 3',
                'parent' => 'PP-02-03',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-01-01',
                'name' => 'Waterbath for Line 1',
                'parent' => 'PP-02-01-01',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-02',
                'name' => 'Vapor and Dust Filtration Line 3',
                'parent' => 'PP-02-03',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-02-01',
                'name' => 'Waterbath for Line 2',
                'parent' => 'PP-02-02-01',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-03',
                'name' => 'Hoppers for Extrusion Line 3',
                'parent' => 'PP-02-03',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-02-03-03-01',
                'name' => 'Waterbath for Line 3',
                'parent' => 'PP-02-03-01',
                'type' => $areaType,
            ],

            // Other PP main areas
            [
                'functional_location' => 'PP-03',
                'name' => 'Finished Goods',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04',
                'name' => 'Utilities',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04-01',
                'name' => 'City Water',
                'parent' => 'PP-04',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04-02',
                'name' => 'Compressed Air',
                'parent' => 'PP-04',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04-03',
                'name' => 'Emergency Generators',
                'parent' => 'PP-04',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04-04',
                'name' => 'Natural Gas',
                'parent' => 'PP-04',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-04-05',
                'name' => 'Process Water',
                'parent' => 'PP-04',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-05',
                'name' => 'Forklifts',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-06',
                'name' => 'Safety Showers',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07',
                'name' => 'Equipment Warehouse',
                'parent' => 'PP',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07-01',
                'name' => 'Relief Device Storage',
                'parent' => 'PP-07',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07-02',
                'name' => 'Waterbath Storage',
                'parent' => 'PP-07',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07-03',
                'name' => 'Tool Storage',
                'parent' => 'PP-07',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07-04',
                'name' => 'New Equipment Storage',
                'parent' => 'PP-07',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-07-05',
                'name' => 'Feed Screw Storage',
                'parent' => 'PP-07',
                'type' => $areaType,
            ],
            [
                'functional_location' => 'PP-08',
                'name' => 'Garage',
                'parent' => 'PP',
                'type' => $areaType,
            ],
        ];

        // Track created locations for parent relationships
        $createdLocations = [];

        foreach ($locations as $locationData) {
            $parentId = null;

            if ($locationData['parent']) {
                $parentLocation = $createdLocations[$locationData['parent']] ?? null;
                if (!$parentLocation) {
                    $this->command->warn("Parent location '{$locationData['parent']}' not found for '{$locationData['functional_location']}'");
                    continue;
                }
                $parentId = $parentLocation->id;
            }

            $location = AmFunctionalLocation::create([
                'functional_location' => $locationData['functional_location'],
                'name' => $locationData['name'],
                'am_parent_functional_location_id' => $parentId,
                'default_dimension_display_value' => 1,
                'am_asset_lifecycle_states_id' => $lifecycleState?->id,
                'am_functional_location_types_id' => $locationData['type']->id,
                'inventory_location_id' => $locationData['functional_location'],
                'inventory_site_id' => $locationData['functional_location'],
                'logistics_location_id' => $locationData['functional_location'],
                'tenant_id' => $tenant->id,
            ]);

            $createdLocations[$locationData['functional_location']] = $location;

            $this->command->info("Created functional location: {$locationData['functional_location']} - {$locationData['name']}");
        }

        $this->command->info('Functional location seeding completed!');
    }
}
