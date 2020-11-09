<?php

namespace Database\Factories;

use App\Models\Fees;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2),
            'method' => $this->faker->randomElement(['Cash','Bank Transfer']),
            'method_remarks' => $this->faker->randomElement(['LB855855','BNETSDSD','5456SDEETE'])
        ];
    }
}
