<?php

namespace Tests\Unit;

use App\Login;
use App\Part;
use Tests\TestCase;

class PartTest extends TestCase
{
    protected $part;

    public function setUp(): void
    {
        parent::setUp();
        $this->part = new Part();
    }

    protected function successfulIndexOrderRoute($order)
    {
        return route('parts.index', ['order='. $order]);
    }

    public function testGetAscOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(Part::class)->create([
                'name' => $letter
            ]);
        }

        $array = array_reverse($array);

        $parts = $this->part->getAll();

        foreach ($parts as $key => $part) {
            $this->assertEquals($part->name, $array[$key]);
        }
    }
    
    public function testGetDescOrder()
    {
        $array = ['A','B','C'];

        foreach ($array as $letter) {
            factory(Part::class)->create([
                'name' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('desc'));

        $parts = $this->part->getAll();

        foreach ($parts as $key => $part) {
            $this->assertEquals($part->name, $array[$key]);
        }
    }

    public function testGetAnyOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(Part::class)->create([
                'name' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()
            ->actingAs(factory(Login::class)->create())
            ->get($this->successfulIndexOrderRoute('any'));

        $parts = $this->part->getAll();

        foreach ($parts as $key => $part) {
            $this->assertEquals($part->name, $array[$key]);
        }
    }
}
