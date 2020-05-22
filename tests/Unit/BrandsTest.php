<?php

namespace Tests\Unit;

use App\Login;
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

    protected function successfulIndexOrderRoute($order)
    {
        return route('brands.index', ['order='. $order]);
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
    
    public function testGetDescOrder()
    {
        $array = ['A','B','C'];

        foreach ($array as $letter) {
            factory(Brands::class)->create([
                'brand' => $letter
            ]);
        }

        $array = array_reverse($array);

        $this->followingRedirects()->actingAs(factory(Login::class)->create())->get( $this->successfulIndexOrderRoute('desc') );
        $brands = $this->brands->getAll();

        foreach($brands as $key => $brand) {
            $this->assertEquals($brand->brand, $array[$key]);
        }
    }   
}
