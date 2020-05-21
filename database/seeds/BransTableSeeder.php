<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use App\Brands;
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
        factory(Brands::class, 50)->create()->each(function ($brand) {
            $values = factory(Brands::class)->make();
    
            if (is_array($values)) {
              $brand->save($values);
            }
        });
    }
}
