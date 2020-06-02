<?php

namespace Tests\Feature;

use App\Login;
use App\Part;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartsTest extends TestCase
{
    use RefreshDatabase;
    
    const NAME = 'Pin de carga';
    const CODE = 'abc123';
    const VIEW_FORM = 'parts.form';
    const VIEW_INDEX = 'parts.index';

    protected $user;
    protected $part;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        $this->part = new Part();
    }

    protected function successfulIndexRoute()
    {
        return route('parts.index');
    }

    protected function successfulIndexPaginateRoute($page)
    {
        return route('parts.index', ['page='. $page]);
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('parts.index', ['order='. $order]);
    }

    protected function successfulCreateRoute()
    {
        return route('parts.create');
    }

    protected function successfulStoreRoute()
    {
        return route('parts.store');
    }

    protected function successfulEditRoute($part)
    {
        return route('parts.edit', $part);
    }

    protected function successfulUpdateRoute($part)
    {
        return route('parts.update', $part);
    }

    protected function successfulDeleteRoute($part)
    {
        return route('parts.destroy', $part);
    }

    public function testUserUnauthenticateCantViewIndex()
    {
        $this->get($this->successfulIndexRoute())
            ->assertRedirect($this->loginGetRoute());
    }
        
    public function testUserCanViewIndex()
    {
        $part = factory(Part::class)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(ucfirst(trans_choice('parts.part', 2)));
        $response->assertSee($part->title);
    }

    public function testUserCanViewEmptyIndex()
    {
        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('error.no-records'));
    }

    public function testUserCanPaginate()
    {
        factory(Part::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(2));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(1));
        $response->assertSuccessful();
    }

    public function testUserCanOrder()
    {
        factory(Part::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('asc'));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('desc'));
        $response->assertSuccessful();
    }

    public function testUserCanPaginateNonExistentPage()
    {
        factory(Part::class, 30)->create();
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
        $response->assertSee(__('buttons.create') . ' ' . trans_choice('parts.part', 1));
    }

    public function testUserCanCreate()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'name' => self::NAME,
                'code' => self::CODE,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::NAME);
        $response->assertSee(self::CODE);
        $response->assertSee(__('parts.store'));
    }
    
    public function testUserCannotCreateWithoutRequired()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'name' => '',
                'code' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => __('parts.name'),
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => __('parts.code'),
        ]));        
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotCreateWithoutCorrectFields()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'name' => Str::random(200),
                'code' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('parts.name', 1),
            'max' => 190
        ]));
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('parts.code', 1),
            'max' => 190
        ]));        
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserUnauthenticateCantViewEdit()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->get($this->successfulEditRoute($part->id))
            ->assertRedirect($this->loginGetRoute());
    }

    public function testUserCanViewEdit()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute($part->id));

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee($part->part);
        $response->assertSee(__('buttons.update') . ' ' . trans_choice('parts.part', 1));
    }

    public function testUserCannotViewEditWithWrongId()
    {
        factory(Part::class)->create([
            'id' => 1
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute(2));

        $response->assertNotFound();
    }

    public function testUserCanUpdate()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);
        
        $this->assertCount(1, $this->part->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($part->id))
            ->put($this->successfulUpdateRoute($part->id), [
                'name' => self::NAME,
                'code' => self::CODE,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::NAME);
        $response->assertSee(self::CODE);
        $response->assertSee(__('parts.update'));
    }

    public function testUserCannotUpdateWithoutRequired()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->part->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($part->id))
            ->put($this->successfulUpdateRoute($part->id), [
                'name' => '',
                'code' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => __('parts.name'),
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => __('parts.code'),
        ]));    
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotUpdateWithoutCorrectFields()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->part->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($part->id))
            ->put($this->successfulUpdateRoute($part->id), [
                'name' => Str::random(200),
                'code' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('parts.name', 1),
            'max' => 190
        ]));
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('parts.code', 1),
            'max' => 190
        ]));   
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCanDelete()
    {
        $part = factory(Part::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->part->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute($part->id), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->part->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('parts.destroy'));
    }

    public function testUserCannotDeleteWithWrongId()
    {
        factory(Part::class)->create([
            'id' => 1
        ]);

        $this->assertCount(1, $this->part->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute(2), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->part->all());
        $response->assertNotFound();
    }
}
