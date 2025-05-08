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
            'date' => $this->faker->date('Y-m-d'),
            'description' => $this->faker->paragraph(),
            'amount' => $this->faker->numberBetween(0, 990000),
            'category' => $this->faker->randomElement(['gaji satpam', 'token listrik', 'perbaikan', 'lainnya']),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
