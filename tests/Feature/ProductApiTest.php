<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    public function test_list_products_returns_json(): void
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'meta' => ['total', 'per_page', 'current_page', 'last_page'],
            'links' => ['first', 'last', 'prev', 'next'],
        ]);
        $this->assertTrue($response->json('success'));
    }

    public function test_list_products_filter_by_category(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id, 'status' => 1]);
        Product::factory()->count(2)->create(['status' => 1]);

        $response = $this->getJson("/api/v1/products?category_id={$category->id}");

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_list_products_filter_by_brand(): void
    {
        $brand = Brand::factory()->create();
        Product::factory()->count(2)->create(['brand_id' => $brand->id, 'status' => 1]);
        Product::factory()->count(3)->create(['status' => 1]);

        $response = $this->getJson("/api/v1/products?brand_id={$brand->id}");

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_list_products_filter_by_price(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->create(['price' => 100000, 'category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);
        Product::factory()->create(['price' => 5000000, 'category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);

        $response = $this->getJson('/api/v1/products?min_price=50000&max_price=200000');

        $response->assertStatus(200);
        $data = $response->json('data');
        foreach ($data as $product) {
            $this->assertGreaterThanOrEqual(50000, $product['price']);
            $this->assertLessThanOrEqual(200000, $product['price']);
        }
    }

    public function test_list_products_sort_price_asc(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->create(['price' => 5000000, 'category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);
        Product::factory()->create(['price' => 100000, 'category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);

        $response = $this->getJson('/api/v1/products?sort=price_asc&per_page=50');

        $response->assertStatus(200);
        $data = $response->json('data');
        $prices = array_column($data, 'price');
        for ($i = 1; $i < count($prices); $i++) {
            $this->assertGreaterThanOrEqual($prices[$i - 1], $prices[$i]);
        }
    }

    public function test_list_products_featured_filter(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->count(2)->featured()->create(['category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);
        Product::factory()->count(3)->create(['category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1, 'is_featured' => 0]);

        $response = $this->getJson("/api/v1/products?is_featured=1&category_id={$category->id}");

        $response->assertStatus(200);
        $this->assertCount(2, $response->json('data'));
    }

    public function test_list_products_pagination(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        Product::factory()->count(15)->create(['category_id' => $category->id, 'brand_id' => $brand->id, 'status' => 1]);

        $response = $this->getJson("/api/v1/products?category_id={$category->id}&per_page=5");

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data'));
        $this->assertEquals(15, $response->json('meta.total'));
        $this->assertEquals(3, $response->json('meta.last_page'));
    }

    public function test_show_product_by_slug(): void
    {
        $product = Product::factory()->create(['status' => 1]);

        $response = $this->getJson("/api/v1/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => ['id', 'name', 'slug', 'price', 'description', 'unit', 'stock', 'category', 'brand'],
            'related',
        ]);
        $this->assertEquals($product->name, $response->json('data.name'));
    }

    public function test_show_nonexistent_product_returns_404(): void
    {
        $response = $this->getJson('/api/v1/products/nonexistent-slug-xyz');

        $response->assertStatus(404);
    }

    public function test_categories_endpoint(): void
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_brands_endpoint(): void
    {
        $response = $this->getJson('/api/v1/brands');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
        $this->assertNotEmpty($response->json('data'));
    }
}
