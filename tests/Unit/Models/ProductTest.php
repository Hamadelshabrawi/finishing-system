<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function product_can_be_created_with_valid_data()
    {
        $product = Product::factory()->create();
        $this->assertDatabaseHas('products', [
            'name' => $product->name
        ]);
    }

    /** @test */
    public function product_requires_name()
    {
        $project = \App\Models\Project::factory()->create();
        $product = Product::factory()->make([
            'name' => null,
            'project_id' => $project->id
        ]);
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        $product->save();
    }

    /** @test */
    public function product_belongs_to_project()
    {
        $project = \App\Models\Project::factory()->create();
        $product = Product::factory()->create(['project_id' => $project->id]);
        
        $this->assertEquals($project->id, $product->project->id);
    }
}
