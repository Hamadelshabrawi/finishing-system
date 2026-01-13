<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\Facades\Artisan;

class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@admin.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/home');
        });
    }

    public function artisan($command, $parameters = [])
    {
        parent::artisan($command, $parameters);

        $this->app[Kernel::class]->setArtisan(null);
    }
}
