<?php

namespace Database\Factories;

use App\Models\AmeReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmeReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AmeReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ame_id' => 1,
            'emp_id' => rand(1, 10),
            'comment' => $this->faker->sentence(),
            'rating' => rand(1, 5)
        ];
    }
}
