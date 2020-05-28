<?php

namespace Tests\Feature;

use App\Login;
use App\DeviceType;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceTypesTest extends TestCase
{
    use RefreshDatabase;
    
    const DEVICE_TYPE = 'Mobile Phone';
    const VIEW_FORM = 'device-types.form';
    const VIEW_INDEX = 'device-types.index';

    protected $user;
    protected $deviceType;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        $this->deviceType = new DeviceType();
    }

    protected function successfulIndexRoute()
    {
        return route('device-types.index');
    }

    protected function successfulIndexPaginateRoute($page)
    {
        return route('device-types.index', ['page='. $page]);
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('device-types.index', ['order='. $order]);
    }

    protected function successfulCreateRoute()
    {
        return route('device-types.create');
    }

    protected function successfulStoreRoute()
    {
        return route('device-types.store');
    }

    protected function successfulEditRoute($deviceType)
    {
        return route('device-types.edit', $deviceType);
    }

    protected function successfulUpdateRoute($deviceType)
    {
        return route('device-types.update', $deviceType);
    }

    protected function successfulDeleteRoute($deviceType)
    {
        return route('device-types.destroy', $deviceType);
    }

    public function testUserUnauthenticateCantViewIndex()
    {
        $this->get($this->successfulIndexRoute())
            ->assertRedirect($this->loginGetRoute());
    }
        
    public function testUserCanViewIndex()
    {
        $deviceType = factory(DeviceType::class)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(ucfirst(trans_choice('device-types.device_type', 2)));
        $response->assertSee($deviceType->title);
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
        factory(DeviceType::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(2));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(1));
        $response->assertSuccessful();
    }

    public function testUserCanOrder()
    {
        factory(DeviceType::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('asc'));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('desc'));
        $response->assertSuccessful();
    }

    public function testUserCanPaginateNonExistentPage()
    {
        factory(DeviceType::class, 30)->create();
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
        $response->assertSee(__('buttons.create') . ' ' . trans_choice('device-types.device_type', 1));
    }

    public function testUserCanCreate()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'device_type' => self::DEVICE_TYPE,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::DEVICE_TYPE);
        $response->assertSee(__('device-types.store'));
    }
    
    public function testUserCannotCreateWithoutDeviceType()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'device_type' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('device-types.device_type', 1),
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotCreateWithoutCorrectDeviceType()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'device_type' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => trans_choice('device-types.device_type', 1),
            'max' => 190
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserUnauthenticateCantViewEdit()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->get($this->successfulEditRoute($deviceType->id))
            ->assertRedirect($this->loginGetRoute());
    }

    public function testUserCanViewEdit()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute($deviceType->id));

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee($deviceType->deviceType);
        $response->assertSee(__('buttons.update') . ' ' . trans_choice('device-types.device_type', 1));
    }

    public function testUserCannotViewEditWithWrongId()
    {
        factory(DeviceType::class)->create([
            'id' => 1
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute(2));

        $response->assertNotFound();
    }

    public function testUserCanUpdate()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);
        
        $this->assertCount(1, $this->deviceType->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($deviceType->id))
            ->put($this->successfulUpdateRoute($deviceType->id), [
                'device_type' => self::DEVICE_TYPE,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::DEVICE_TYPE);
        $response->assertSee(__('device-types.update'));
    }

    public function testUserCannotUpdateWithoutDeviceType()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->deviceType->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($deviceType->id))
            ->put($this->successfulUpdateRoute($deviceType->id), [
                'device_type' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('device-types.device_type', 1),
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotUpdateWithoutCorrectDeviceType()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->deviceType->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($deviceType->id))
            ->put($this->successfulUpdateRoute($deviceType->id), [
                'device_type' => Str::random(200),
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => trans_choice('device-types.device_type', 1),
            'max' => 190
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCanDelete()
    {
        $deviceType = factory(DeviceType::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->deviceType->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute($deviceType->id), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->deviceType->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('device-types.destroy'));
    }

    public function testUserCannotDeleteWithWrongId()
    {
        factory(DeviceType::class)->create([
            'id' => 1
        ]);

        $this->assertCount(1, $this->deviceType->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute(2), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->deviceType->all());
        $response->assertNotFound();
    }
}
