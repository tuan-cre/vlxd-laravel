<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    public function test_product_belongs_to_brand(): void
    {
        $brand = Brand::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id]);

        $this->assertInstanceOf(Brand::class, $product->brand);
        $this->assertEquals($brand->id, $product->brand->id);
    }

    public function test_product_has_many_images(): void
    {
        $product = Product::factory()->create();

        $this->assertIsObject($product->images);
    }

    public function test_product_fillable_fields(): void
    {
        $product = new Product();

        $expected = [
            'category_id', 'brand_id', 'name', 'slug', 'price',
            'sale_price', 'thumbnail', 'description', 'content',
            'unit', 'stock', 'views', 'is_featured', 'status',
            'created_at', 'updated_at',
        ];

        $this->assertEquals($expected, $product->getFillable());
    }

    public function test_product_factory_creates_valid_product(): void
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $this->assertEquals(1, $product->status);
    }

    public function test_product_featured_state(): void
    {
        $product = Product::factory()->featured()->create();

        $this->assertEquals(1, $product->is_featured);
    }

    public function test_product_inactive_state(): void
    {
        $product = Product::factory()->inactive()->create();

        $this->assertEquals(0, $product->status);
    }
}
