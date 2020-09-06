<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Laravel\Sanctum\Sanctum;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            factory(User::class)->create()
        );
    }

    public function test_index()
    {
        factory(Product::class, 5)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5);
    }

    public function test_create_new_product()
    {
        $data = [
            'name' => 'Hola',
            'price' => 10,
        ];
        $response = $this->postJson('/api/products', $data);

        $response->assertStatus(201);
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data, ['content-type', 'application/json']);
        $response->assertStatus(200);
        //$response->assertHeader('content-type', 'application/json');
    }

    public function test_show_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }

}
