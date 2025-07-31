<?php

namespace Database\Factories;

use App\Models\AmFunctionalLocationLifecycleModel;
use App\Models\AmFunctionalLocationLifecycleState;
use App\Models\AmFunctionalLocationLifecycleStateSequence;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AmFunctionalLocationLifecycleStateSequence>
 */
class AmFunctionalLocationLifecycleStateSequenceFactory extends Factory
{
    protected $model = AmFunctionalLocationLifecycleStateSequence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lifecycle_model_id' => AmFunctionalLocationLifecycleModel::factory(),
            'lifecycle_state_id' => AmFunctionalLocationLifecycleState::factory(),
            'line' => $this->faker->numberBetween(1, 10),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
