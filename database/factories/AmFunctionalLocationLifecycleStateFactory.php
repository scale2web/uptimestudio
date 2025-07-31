<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AmFunctionalLocationLifecycleState>
 */
class AmFunctionalLocationLifecycleStateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lifecycle_state' => $this->faker->randomElement(['Active', 'Ended', 'New']),
            'name' => $this->faker->sentence,
            'allow_delete_location' => $this->faker->boolean,
            'allow_install_maintenance_assets' => $this->faker->boolean,
            'allow_new_sub_locations' => $this->faker->boolean,
            'allow_rename_location' => $this->faker->boolean,
            'create_location_maintenance_asset' => $this->faker->boolean,
            'functional_location_active' => $this->faker->boolean,
            'maintenance_asset_lifecycle_state_id' => null,
            'tenant_id' => \App\Models\Tenant::factory(),
        ];
    }
}
