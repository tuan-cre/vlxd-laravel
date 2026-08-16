<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    public function test_product_listing_page_returns_ok(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }

    public function test_product_listing_displays_sidebar_filters(): void
    {
        $response = $this->get('/products');

        $response->assertSee('Search Filters');
        $response->assertSee('Category');
        $response->assertSee('Brand');
        $response->assertSee('Price Range');
    }

    public function test_filter_by_category(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id, 'status' => 1]);

        $response = $this->get("/products?category_id={$category->id}");

        $response->assertStatus(200);
        $response->assertSee('· Filtered');
    }

    public function test_filter_by_brand(): void
    {
        $brand = Brand::factory()->create();
        Product::factory()->count(2)->create(['brand_id' => $brand->id, 'status' => 1]);

        $response = $this->get("/products?brand_id={$brand->id}");

        $response->assertStatus(200);
    }

    public function test_filter_by_price_range(): void
    {
        $response = $this->get('/products?min_price=50000&max_price=200000');

        $response->assertStatus(200);
    }

    public function test_sort_by_price(): void
    {
        $response = $this->get('/products?sort=price_asc');

        $response->assertStatus(200);
    }

    public function test_product_detail_page_returns_ok(): void
    {
        $product = Product::factory()->create(['status' => 1]);

        $response = $this->get("/products/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_nonexistent_product_returns_404(): void
    {
        $response = $this->get('/products/nonexistent-slug-xyz');

        $response->assertStatus(404);
    }

    public function test_ajax_filter_returns_json_with_html(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id, 'status' => 1]);

        $response = $this->getJson("/products/filter?category_id={$category->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure(['html']);
        $this->assertNotEmpty($response->json('html'));
    }
}
