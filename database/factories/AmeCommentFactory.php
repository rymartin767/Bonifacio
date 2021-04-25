<?php

namespace Database\Factories;

use App\Models\Ame;
use App\Models\AmeComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmeCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AmeComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ame_id' => Ame::factory(),
            'user_id' => rand(1, 2000),
            'body' => $this->faker->sentence()
        ];
    }
}
