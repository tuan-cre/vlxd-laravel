<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_returns_ok(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_displays_products(): void
    {
        $response = $this->get('/');

        $response->assertSee('Building Materials');
        $response->assertSee('Featured Products');
    }

    public function test_homepage_displays_categories(): void
    {
        $response = $this->get('/');

        $response->assertSee('Product Categories');
    }
}
