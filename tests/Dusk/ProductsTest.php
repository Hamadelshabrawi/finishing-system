<?php

namespace Tests\Dusk;

use App\Models\Product;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductsTest extends DuskTestCase
{
    /** @test */
    public function can_add_new_product_via_ui()
    {
        $this->browse(function (Browser $browser) {
            $product = Product::factory()->make();
            
            $browser->loginAs(User::factory()->create())
                    ->visit('/products')
                    ->click('@add-product-button')
                    ->type('name', $product->name)
                    ->type('description', $product->description)
                    ->press('@save-button')
                    ->assertPathIs('/products')
                    ->assertSee($product->name);
        });
    }

    /** @test */
    public function can_filter_products()
    {
        $product = Product::factory()->create();
        
        $this->browse(function (Browser $browser) use ($product) {
            $browser->loginAs(User::factory()->create())
                    ->visit('/products')
                    ->type('@search-input', $product->name)
                    ->assertSee($product->name);
        });
    }
}
