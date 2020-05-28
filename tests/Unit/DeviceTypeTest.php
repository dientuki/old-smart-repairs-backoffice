<?php

namespace Tests\Unit;

use App\Login;
use App\DeviceType;
use Tests\TestCase;

class DeviceTypeTest extends TestCase
{
    protected $deviceType;

    public function setUp(): void
    {
        parent::setUp();
        $this->deviceType = new DeviceType();
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('deviceTypes.index', ['order='. $order]);
    }

    public function testGetAscOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(DeviceType::class)->create([
                'deviceType' => $letter
            ]);
        }

        $array = array_reverse($array);

        $deviceTypes = $this->deviceType->getAll();

        foreach ($deviceTypes as $key => $deviceType) {
            $this->assertEquals($deviceType->deviceType, $array[$key]);
        }
    }
    
    public function testGetDescOrder()
    {
        $array = ['A','B','C'];

        foreach ($array as $letter) {
            factory(DeviceType::class)->create([
                'deviceType' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('desc'));

        $deviceTypes = $this->deviceType->getAll();

        foreach ($deviceTypes as $key => $deviceType) {
            $this->assertEquals($deviceType->deviceType, $array[$key]);
        }
    }

    public function testGetAnyOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(DeviceType::class)->create([
                'deviceType' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('any'));

        $deviceTypes = $this->deviceType->getAll();

        foreach ($deviceTypes as $key => $deviceType) {
            $this->assertEquals($deviceType->deviceType, $array[$key]);
        }
    }
}
