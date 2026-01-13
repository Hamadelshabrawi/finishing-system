<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    public function setUp(): void
    {
        parent::setUp();
        // Create admin role if it doesn't exist
        \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'Admin'
        ]);
        
        // Create admin user if it doesn't exist
        $this->admin = \App\Models\User::where('email', 'admin@admin.com')->first();
        if (!$this->admin) {
            $this->admin = \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'user_type' => 'Admin'
            ]);
            $this->admin->assignRole('Admin');
        }
        $this->actingAs($this->admin);
    }

    /** @test */
    public function can_view_product_list()
    {
        Product::factory(5)->create();
        $response = $this->get(route('products.index'));
        
        $response->assertStatus(200)
                 ->assertViewHas('products');
    }

    /** @test */
    public function can_create_new_product()
    {
        $project = \App\Models\Project::factory()->create();
        
        $response = $this->post(route('products.store'), [
            'project_id' => $project->id,
            'name' => 'Test Product',
            'description' => 'Test Description'
        ]);
        
        $product = Product::where('name', 'Test Product')->first();
        $response->assertRedirect(route('products.show', $product->id));
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }

    /** @test */
    public function cannot_create_product_with_invalid_data()
    {
        $response = $this->post(route('products.store'), [
            'name' => '',
            'description' => 'Test Description'
        ]);
        
        $response->assertSessionHasErrors(['name', 'project_id']);
    }

    /** @test */
    public function cannot_create_product_without_project()
    {
        $response = $this->post(route('products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description'
        ]);
        
        $response->assertSessionHasErrors(['project_id']);
    }
}
