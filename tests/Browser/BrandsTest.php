<?php

namespace Tests\Browser;

use App\Brand;
use App\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrandsTest extends DuskTestCase
{

    protected function successfulIndexRoute()
    {
        return route('brands.index');
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        factory(Brand::class)->create();
        $user = factory(Login::class)->create();
        
        $this->browse(function (Browser $browser) {
            //dd(route('login'));
            $browser->visit(route('login'))->dump();

            //->assertSee("Nombre de usuario");
            //->loginAs(1)->visit($this->successfulIndexRoute());
            /*
            factory(Login::class)->create();

            $browser->loginAs(1)->visit($this->successfulIndexRoute());
            dd($browser);
            */
            /*
                    ->assertSee(ucfirst(trans_choice('brands.brand', 2)))
                    ->select('select', 'desc');
                    */
        });
    }
}
