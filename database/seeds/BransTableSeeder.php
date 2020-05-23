<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use App\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Brand::class, 50)->create()->each(function ($brand) {
            $values = factory(Brand::class)->make();
    
            if (is_array($values)) {
                $brand->save($values);
            }
        });
    }
}
