<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->randomElement(['Visa Fees', 'College Fees', 'Hostel Fees']),
            'amount' => $this->faker->randomFloat(2),
            'method' => $this->faker->randomElement(['Cash', 'Bank Transfer']),
            'method_remarks' => $this->faker->randomElement(['LB855855', 'BNETSDSD', '5456SDEETE']),
        ];
    }
}
