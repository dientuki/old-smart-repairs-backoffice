<?php

namespace Tests\Feature;

use App\Brand;
use App\Login;
use App\Device;
use App\DeviceType;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DevicesTest extends TestCase
{
    use RefreshDatabase;
    
    const TRADENAME = 'J5 plus';
    const TECHNICAL = 'SM-356';
    const URL = 'http://www.ciudad.com.ar';
    const VIEW_FORM = 'devices.form';
    const VIEW_INDEX = 'devices.index';

    protected $user;
    protected $device;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        $this->device = new Device();
    }

    protected function successfulIndexRoute()
    {
        return route('devices.index');
    }

    protected function successfulIndexPaginateRoute($page)
    {
        return route('devices.index', ['page='. $page]);
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('devices.index', ['order='. $order]);
    }

    protected function successfulCreateRoute()
    {
        return route('devices.create');
    }

    protected function successfulStoreRoute()
    {
        return route('devices.store');
    }

    protected function successfulEditRoute($device)
    {
        return route('devices.edit', $device);
    }

    protected function successfulUpdateRoute($device)
    {
        return route('devices.update', $device);
    }

    protected function successfulDeleteRoute($device)
    {
        return route('devices.destroy', $device);
    }

    public function testUserUnauthenticateCantViewIndex()
    {
        $this->get($this->successfulIndexRoute())
            ->assertRedirect($this->loginGetRoute());
    }
        
    public function testUserCanViewIndex()
    {
        $device = factory(Device::class)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexRoute());

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(ucfirst(trans_choice('devices.device', 2)));
        $response->assertSee($device->title);
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
        factory(Device::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(2));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexPaginateRoute(1));
        $response->assertSuccessful();
    }

    public function testUserCanOrder()
    {
        factory(Device::class, 30)->create();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('asc'));
        $response->assertSuccessful();

        $response = $this->actingAs($this->user)->get($this->successfulIndexOrderRoute('desc'));
        $response->assertSuccessful();
    }

    public function testUserCanPaginateNonExistentPage()
    {
        factory(Device::class, 30)->create();
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
        $response->assertSee(__('buttons.create') . ' ' . trans_choice('devices.device', 1));
    }

    public function testUserCanCreate()
    {
        $deviceType = factory(DeviceType::class)->create();
        $brand = factory(Brand::class)->create();

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'tradename' => self::TRADENAME,
                'technical_name' => self::TECHNICAL,
                'device_type_id' => $deviceType->id,
                'brand_id' => $brand->id,
                'url' => self::URL,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::TRADENAME);
        $response->assertSee(self::TECHNICAL);
        $response->assertSee($deviceType->device_type);
        $response->assertSee($brand->brand);
        $response->assertSee(__('device-types.store'));
    }
    
    public function testUserCannotCreateWithoutRequiredFields()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'tradename' => '',
                'technical_name' => '',
                'device_type_id' => '',
                'brand_id' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => __('devices.tradename')
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => __('devices.technical_name')
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('device-types.device_type', 1)
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('brands.brand', 1)
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotCreateWithoutCorrectFields()
    {
        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulCreateRoute())
            ->post($this->successfulStoreRoute(), [
                'tradename' => Str::random(200),
                'technical_name' => Str::random(200),
                'device_type_id' => 5,
                'brand_id' => 5,
                'url' => 'wrong-url',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('devices.tradename'),
            'max' => 190
        ]));
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('devices.technical_name'),
            'max' => 190
        ]));
        $response->assertSee(__('validation.exists', [
            'attribute' => trans_choice('device-types.device_type', 1)
        ]));
        $response->assertSee(__('validation.exists', [
            'attribute' => trans_choice('brands.brand', 1)
        ]));
        $response->assertSee(__('validation.url', [
            'attribute' => __('devices.url')
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserUnauthenticateCantViewEdit()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->get($this->successfulEditRoute($device->id))
            ->assertRedirect($this->loginGetRoute());
    }

    public function testUserCanViewEdit()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100)
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute($device->id));

        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee($device->device);
        $response->assertSee(__('buttons.update') . ' ' . trans_choice('devices.device', 1));
    }

    public function testUserCannotViewEditWithWrongId()
    {
        factory(Device::class)->create([
            'id' => 1
        ]);

        $response = $this->actingAs($this->user)->get($this->successfulEditRoute(2));

        $response->assertNotFound();
    }

    public function testUserCanUpdate()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100),
        ]);
        $deviceType = factory(DeviceType::class)->create();
        $brand = factory(Brand::class)->create();
        
        $this->assertCount(1, $this->device->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($device->id))
            ->put($this->successfulUpdateRoute($device->id), [
                'tradename' => self::TRADENAME,
                'technical_name' => self::TECHNICAL,
                'device_type_id' => $deviceType->id,
                'brand_id' => $brand->id,
                'url' => self::URL,
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(self::TRADENAME);
        $response->assertSee(self::TECHNICAL);
        $response->assertSee($deviceType->device_type);
        $response->assertSee($brand->brand);
        $response->assertSee(__('device-types.update'));
    }

    public function testUserCannotUpdateWithoutRequiredFields()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->device->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($device->id))
            ->put($this->successfulUpdateRoute($device->id), [
                'tradename' => '',
                'technical_name' => '',
                'device_type_id' => '',
                'brand_id' => '',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.required', [
            'attribute' => __('devices.tradename')
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => __('devices.technical_name')
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('device-types.device_type', 1)
        ]));
        $response->assertSee(__('validation.required', [
            'attribute' => trans_choice('brands.brand', 1)
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCannotUpdateWithoutCorrectFields()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->device->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulEditRoute($device->id))
            ->put($this->successfulUpdateRoute($device->id), [
                'tradename' => Str::random(200),
                'technical_name' => Str::random(200),
                'device_type_id' => 5,
                'brand_id' => 5,
                'url' => 'wrong-url',
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_FORM);
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('devices.tradename'),
            'max' => 190
        ]));
        $response->assertSee(__('validation.max.string', [
            'attribute' => __('devices.technical_name'),
            'max' => 190
        ]));
        $response->assertSee(__('validation.exists', [
            'attribute' => trans_choice('device-types.device_type', 1)
        ]));
        $response->assertSee(__('validation.exists', [
            'attribute' => trans_choice('brands.brand', 1)
        ]));
        $response->assertSee(__('validation.url', [
            'attribute' => __('devices.url')
        ]));
        $response->assertSee(__('error.in-forms'));
    }

    public function testUserCanDelete()
    {
        $device = factory(Device::class)->create([
            'id' => random_int(1, 100)
        ]);

        $this->assertCount(1, $this->device->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute($device->id), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(0, $this->device->all());
        $response->assertSuccessful();
        $response->assertViewIs(self::VIEW_INDEX);
        $response->assertSee(__('device-types.destroy'));
    }

    public function testUserCannotDeleteWithWrongId()
    {
        factory(Device::class)->create([
            'id' => 1
        ]);

        $this->assertCount(1, $this->device->all());

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->from($this->successfulIndexRoute())
            ->delete($this->successfulDeleteRoute(2), [
                '_token' => csrf_token(),
            ]);

        $this->assertCount(1, $this->device->all());
        $response->assertNotFound();
    }
}
