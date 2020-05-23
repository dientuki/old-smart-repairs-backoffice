<?php

namespace Tests\Unit\Http\Controllers;

use App\Brand;
use App\Login;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class BrandsControllerTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(Login::class)->create();
    }

    protected function successfulIndexRoute()
    {
        return route('brands.index');
    }

    protected function successfulCreateRoute()
    {
        return route('brands.create');
    }

    protected function successfulEditRoute($id)
    {
        return route('brands.edit', ['brand' => $id]);
    }

    public function testUserCanViewIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
    }

    public function testUserCanViewCreate()
    {
        $response = $this->actingAs($this->user)->get($this->successfulCreateRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.form');
    }

    public function testUserCanViewEdit()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute($brand->id));

        $response->assertSuccessful();
        $response->assertViewIs('brands.form');
    }
}
