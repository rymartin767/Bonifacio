<?php

namespace Database\Factories;

use App\Models\Ame;
use App\Models\AmeRating;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmeRatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AmeRating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ame_id' => Ame::factory(),
            'user_id' => 1,
            'rating' => $this->faker->numberBetween(1, 5)
        ];
    }
}
