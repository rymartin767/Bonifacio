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
            'name' => 'Dr. John Capurro',
            'street' => '123 University Blvd',
            'city' => 'Cincinnati',
            'state' => 'Ohio',
            'zip' => '44444',
            'phone' => '4449098765'
        ];
    }
}
