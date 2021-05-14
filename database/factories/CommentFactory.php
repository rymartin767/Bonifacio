<?php

namespace Database\Factories;

use App\Models\Ame;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name' => 'Ryan Martin',
            'user_employee_number' => 450765,
            'body' => 'A comment by Ryan Martin'
        ];
    }
}
