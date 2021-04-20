<?php

namespace Database\Factories;

use App\Models\Ame;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ame::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => 'OH',
            'zip' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
