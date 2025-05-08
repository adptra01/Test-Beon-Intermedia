<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\HouseResident;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

class HouseResidentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HouseResident::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'house_id' => House::inRandomOrder()->value('id'),
            'resident_id' => Resident::inRandomOrder()->value('id'),

            'start_date' => $this->faker->date('Y-m-d'),
            'end_date' => $this->faker->date('Y-m-d'),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
