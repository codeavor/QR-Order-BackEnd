<?php

namespace Database\Factories;

use App\Models\Umbrella;
use Illuminate\Database\Eloquent\Factories\Factory;

class UmbrellaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Umbrella::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(1),
        ];
    }
}
