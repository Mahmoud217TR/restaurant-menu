<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'menu_id' => Menu::factory(),
        ];
    }

    public function forMenu(Menu $menu)
    {
        return $this->state(fn (array $attributes) => [
            'menu_id' => $menu->id,
        ]);
    }
}
