<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_product_via_api(): void
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Laptop',
            'price' => 1500,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Laptop')
            ->assertJsonPath('price', 1500);

        $this->assertDatabaseHas('products', [
            'name' => 'Laptop',
            'price' => 1500,
        ]);
    }
}
