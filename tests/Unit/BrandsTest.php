<?php

namespace Tests\Unit;

use App\Brands;
use Tests\TestCase;

class BrandsTest extends TestCase
{
    protected $brands;

    public function setUp(): void
    {
        parent::setUp();
        $this->brands = new Brands();
    }

    public function testGetAscOrder()
    {
        $array = ['C','B','A'];

        foreach ($array as $letter) {
            factory(Brands::class)->create([
                'brand' => $letter
            ]);
        }

        $array = array_reverse($array);

        $brands = $this->brands->getAll();

        foreach ($brands as $key => $brand) {
            $this->assertEquals($brand->brand, $array[$key]);
        }
    }
}
