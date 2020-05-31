<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use App\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([
            'tradename' => 'Blade A5',
            'technical_name' => 'Blade A5',
            'url' => 'https://www.gsmarena.com/zte_blade_a5_(2019)-9712.php',
            'device_type_id' => 1,
            'brand_id' => 1
        ]);

        DB::table('devices')->insert([
            'tradename' => 'Moto G7',
            'technical_name' => 'XT1962',
            'url' => 'https://www.gsmarena.com/motorola_moto_g7-9357.php',
            'device_type_id' => 1,
            'brand_id' => 2
        ]);

        DB::table('devices')->insert([
            'tradename' => 'Galaxy J2 Core',
            'technical_name' => 'SM-J260M/DS',
            'url' => 'https://www.gsmarena.com/samsung_galaxy_j2_core-9255.php',
            'device_type_id' => 1,
            'brand_id' => 3
        ]);
    }
}
