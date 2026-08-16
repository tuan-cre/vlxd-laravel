<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'name' => fake()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'price' => random_int(50000, 5000000),
            'sale_price' => 0,
            'thumbnail' => null,
            'description' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'unit' => fake()->randomElement(['Cái', 'Chiếc', 'Bao', 'Kg', 'm']),
            'stock' => random_int(0, 100),
            'views' => 0,
            'is_featured' => 0,
            'status' => 1,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => 1]);
    }

    public function onSale(): static
    {
        return $this->state(fn (array $attrs) => [
            'sale_price' => (int) ($attrs['price'] * random_int(10, 80) / 100),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['status' => 0]);
    }
}
