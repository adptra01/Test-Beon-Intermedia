<?php

namespace Database\Factories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resident::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name(),
            'ktp_photo' => $this->faker->image(),
            'status' => $this->faker->randomElement(['tetap', 'kontrak']),
            'phone_number' => $this->faker->numerify('0##########'),
            'is_married' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
