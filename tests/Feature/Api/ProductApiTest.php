<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_product_list_via_api()
    {
        Product::factory(3)->create();
        $response = $this->getJson('/api/products');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'description',
                             'project_id',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function can_get_single_product_via_api()
    {
        $product = Product::factory()->create();
        $response = $this->getJson("/api/products/{$product->id}");
        
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $product->id,
                         'name' => $product->name,
                         'description' => $product->description,
                         'project_id' => $product->project_id,
                         'created_at' => $product->created_at->toISOString(),
                         'updated_at' => $product->updated_at->toISOString()
                     ]
                 ]);
    }

    /** @test */
    public function cannot_get_nonexistent_product()
    {
        $response = $this->getJson('/api/products/99999');
        $response->assertStatus(404);
    }
}
