<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

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
        DB::table('brands')->insert([
            'brand' => 'Motorola',
        ]);
        DB::table('brands')->insert([
            'brand' => 'Samsung',
        ]);
        DB::table('brands')->insert([
            'brand' => 'Xiaomi',
        ]);
    }
}
