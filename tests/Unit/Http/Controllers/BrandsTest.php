<?php

use App\Login;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class BrandsTest extends TestCase
{
    protected $user;

    public function setUp(): void {

        parent::setUp();

        $this->user = factory(Login::class)->create();
    }

    protected function successfulIndexRoute()
    {
        return route('brands.index');
    }

    public function testUserCanViewIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulBrandRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
    }
}
