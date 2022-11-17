<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Category;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence(),
            "description" => $this->faker->text(),
            "price" => Money::USD($this->faker->numberBetween(0,1000)),
            "currency" => Currency::USD,
            "category_id" => Category::factory(),
        ];
    }

    public function forCategory(Category $category)
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $category->id,
        ]);
    }

    public function withPrice(Money $price, Currency $currency = Currency::USD)
    {
        return $this->state(fn (array $attributes) => [
            "price" => $price,
            "currency" => $currency,
        ]);
    }

}
