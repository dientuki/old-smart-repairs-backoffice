<?php

namespace Tests\Feature;

use App\Login;
use App\Brand;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandsTest extends TestCase
{
    use RefreshDatabase;
    
    const BRAND = 'Motorolla';
    const VIEW_FORM = 'brands.form';
    const VIEW_INDEX = 'brands.index';

    protected $user;
    protected $brand;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        $this->brand = new Brand();
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

    protected function successfulEditRoute($brand)
    {
        return route('brands.edit', $brand);
    }

    protected function successfulUpdateRoute($brand)
    {
        return route('brands.update', $brand);
    }

    protected function successfulDeleteRoute($brand)
    {
        return route('brands.destroy', $brand);
    }    

    public function testUserUnauthenticateCantViewIndex()
    {
        $this->get($this->successfulIndexRoute())
            ->assertRedirect($this->loginGetRoute());
    }
        
    public function testUserCanViewIndex()
    {
        $brand = factory(Brand::class)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(ucfirst(trans_choice('brands.brand', 2)));
        $response->assertSee($brand->title);
    }

    public function testUserCanViewEmptyIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('error.no-record'));
    }

    public function testUserCanPaginate()
    {
        factory(Brand::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(2));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(1));
        $response->assertSuccessful();
    }

    public function testUserCanOrder()
    {
        factory(Brand::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('asc'));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('desc'));
        $response->assertSuccessful();
    }

    public function testUserCanPaginateNonExistentPage()
    {
        factory(Brand::class, 30)->create();
        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(80));
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('pagination.empty'));
    }

    public function testUserUnauthenticateCantViewCreate()
    {
        $this->get($this->successfulCreateRoute())
            ->assertRedirect($this->loginGetRoute());
    }

    public function testUserCanViewCreate()
    {
        $response = $this->actingAs($this->user)->get($this->successfulCreateRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('buttons.create') . ' ' . trans_choice('brands.brand', 1));
    }

    public function testUserCanCreate()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => self::BRAND,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brand->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::BRAND);
    }
    
    public function testUserCannotCreateWithoutBrand()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->brand->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('brands.brand', 1),
        ]));
    }

    public function testUserCannotCreateWithoutCorrectBrand()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'brand' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->brand->all());
        $response->assertSuccessful();
        $response->assertSee(__('validation.max.string', [
            'attribute' => trans_choice('brands.brand', 1),
            'max' => 190
        ]));
    }

    public function testUserUnauthenticateCantViewEdit()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->get($this->successfulEditRoute($brand->id))
            ->assertRedirect($this->loginGetRoute());
    }

    public function testUserCanViewEdit()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute($brand->id));

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee($brand->brand);
        $response->assertSee(__('buttons.update') . ' ' . trans_choice('brands.brand', 1));
    }

    public function testUserCannotViewEditWithWrongId()
    {
        factory(Brand::class)->create([
            'id' => 1
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute(2));

        $response->assertNotFound();
    }

    public function testUserCanUpdate()
    {
        //Session::start();

        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);
        
        $this->assertCount(1, $this->brand->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($brand->id))
            ->put($this->successfulUpdateRoute($brand->id), [
                'brand' => self::BRAND,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brand->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::BRAND);
    }

    public function testUserCannotUpdateWithoutBrand()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->brand->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($brand->id))
            ->put($this->successfulUpdateRoute($brand->id), [
                'brand' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brand->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('brands.brand', 1),
        ]));
    }

    public function testUserCannotUpdateWithoutCorrectBrand()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->brand->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($brand->id))
            ->put($this->successfulUpdateRoute($brand->id), [
                'brand' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brand->all());
        $response->assertSuccessful();
        $response->assertSee(__('validation.max.string', [
            'attribute' => trans_choice('brands.brand', 1),
            'max' => 190
        ]));
    }

    public function testUserCanDelete()
    {
        $brand = factory(Brand::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->brand->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute($brand->id), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->brand->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
    }

    public function testUserCannotDeleteWithWrongId()
    {
        $brand = factory(Brand::class)->create([
            'id' => 1
        ]);

        $this->assertCount(1, $this->brand->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute(2), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->brand->all());
        $response->assertNotFound();
    }    
}
