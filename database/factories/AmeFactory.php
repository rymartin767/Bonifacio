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
            'name' => $this->faker->name(),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'zip' => $this->faker->postcode(),
            'phone' => $this->faker->numerify('###-###-####'),
            'url' => $this->faker->url()
        ];
    }
}
