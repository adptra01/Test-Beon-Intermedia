<?php

namespace Database\Factories;

use App\Models\House;
use App\Models\Payment;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

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

            'month' => $this->faker->date('Y-m'),
            'type' => $this->faker->randomElement(['kebersihan', 'satpam']),
            'amount' => $this->faker->numberBetween(0, 999),
            'status' => $this->faker->randomElement(['lunas', 'belum']),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
