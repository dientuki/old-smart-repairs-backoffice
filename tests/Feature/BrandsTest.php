<?php

namespace Tests\Feature;

use App\Login;
use App\Brands;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandsTest extends TestCase
{
    use RefreshDatabase;
    
    const BRAND = 'Motorolla';

    protected $user;
    protected $brands;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        $this->brands = new Brands();
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

    protected function successfulCreateRoute()
    {
        return route('brands.create');
    }

    protected function successfulStoreRoute()
    {
        return route('brands.store');
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

    public function testUserCanViewCreate()
    {
        $response = $this->actingAs($this->user)->get($this->successfulCreateRoute());

        $response->assertSuccessful();
        $response->assertViewIs('brands.form');
        $response->assertSee(__('buttons.create') . ' ' . trans_choice('brands.brand', 1));
    }

    public function testUserCanCreate()
    {
        Session::start();
        
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => self::BRAND,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brands->all());
        $response->assertSuccessful();
        $response->assertViewIs('brands.index');
        $response->assertSee(self::BRAND);
    }
    
    public function testUserCannotCreateWithoutBrand()
    {
        $response = $this->actingAs($this->user)
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->brands->all());
        $response->assertRedirect($this->successfulCreateRoute());
        $response->assertSessionHasErrors('brand');
    }

    public function testUserCannotCreateWithoutCorrectBrand()
    {
        $response = $this->actingAs($this->user)
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->brands->all());
        $response->assertRedirect($this->successfulCreateRoute());
        $response->assertSessionHasErrors('brand');
    }
}
