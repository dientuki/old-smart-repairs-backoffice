<?php

namespace Tests\Feature;

use App\Login;
use App\Brands;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class BrandsTest extends TestCase
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

    protected function successfulIndexPaginateRoute($page)
    {
        return route('brands.index', ['page='. $page]);
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('brands.index', ['order='. $order]);
    }    

    public function testUserCanViewIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
        $response->assertSee(ucfirst(trans_choice('brands.brand', 2)));
    }

    public function testUserCanViewEmptyIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
        $response->assertSee(__('error.no-record'));
    }    

    public function testUserCanPaginate()
    {
        factory(Brands::class, 30)->create();
        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(2));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(1));
        $response->assertSuccessful();
    }

    public function testUserCanOrder()
    {
        factory(Brands::class, 30)->create();
        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('asc'));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('desc'));
        $response->assertSuccessful();
    }

    public function testUserCanPaginateInexistePage()
    {
        factory(Brands::class, 30)->create();
        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(80));
        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
        $response->assertSee(__('pagination.empty'));
    }    
}
