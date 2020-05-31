<?php

namespace Tests\Unit;

use App\Login;
use App\Device;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    protected $device;

    public function setUp(): void
    {
        parent::setUp();
        $this->device = new Device();
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('device-types.index', ['order='. $order]);
    }

    public function testGetAscOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(Device::class)->create([
                'tradename' => $letter
            ]);
        }

        $array = array_reverse($array);

        $devices = $this->device->getAll();

        foreach ($devices as $key => $device) {
            $this->assertEquals($device->tradename, $array[$key]);
        }
    }
    
    public function testGetDescOrder()
    {
        $array = ['A','B','C'];

        foreach ($array as $letter) {
            factory(Device::class)->create([
                'tradename' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('desc'));

        $devices = $this->device->getAll();

        foreach ($devices as $key => $device) {
            $this->assertEquals($device->tradename, $array[$key]);
        }
    }

    public function testGetAnyOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(Device::class)->create([
                'tradename' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('any'));

        $devices = $this->device->getAll();

        foreach ($devices as $key => $device) {
            $this->assertEquals($device->tradename, $array[$key]);
        }
    }
}
