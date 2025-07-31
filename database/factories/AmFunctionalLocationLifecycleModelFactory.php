<?php

namespace Database\Factories;

use App\Models\AmFunctionalLocationLifecycleModel;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AmFunctionalLocationLifecycleModel>
 */
class AmFunctionalLocationLifecycleModelFactory extends Factory
{
    protected $model = AmFunctionalLocationLifecycleModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $models = [
            ['lifecycle_model_name' => 'GLOBAL', 'name' => 'Standard functional location stage group'],
            ['lifecycle_model_name' => 'INDUSTRIAL', 'name' => 'Industrial equipment lifecycle model'],
            ['lifecycle_model_name' => 'FACILITY', 'name' => 'Facility management lifecycle model'],
            ['lifecycle_model_name' => 'INFRASTRUCTURE', 'name' => 'Infrastructure asset lifecycle model'],
        ];

        $selectedModel = $this->faker->randomElement($models);

        return [
            'lifecycle_model_name' => $selectedModel['lifecycle_model_name'],
            'name' => $selectedModel['name'],
            'tenant_id' => 1, // Will be overridden by seeder
        ];
    }
}
