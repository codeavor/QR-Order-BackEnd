<?php

namespace Database\Factories;

use App\Models\ExtraCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExtraCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExtraCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => 'radioButton'
        ];
    }
}
