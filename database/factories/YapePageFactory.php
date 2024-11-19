<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class YapePageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name=$this->faker->unique()->sentence();
        return [
            'name'=>$name,
            'telefono'=>$this->faker->randomElement([9,9]),
            'mensaje'=>'scrapingPerúJuliaca.com',
        ];
    }
}
