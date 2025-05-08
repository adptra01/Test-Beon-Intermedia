<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->name(),
            'email_verified_at' => fake()->date('Y-m-d H:i:s'),
            'password' => bcrypt('password'),
            // 'remember_token' => fake()->text(fake()->numberBetween(5, 4096)),
            'created_at' => fake()->date('Y-m-d H:i:s'),
            'updated_at' => fake()->date('Y-m-d H:i:s'),
        ];
    }
}
