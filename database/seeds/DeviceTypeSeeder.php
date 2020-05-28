<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use App\DeviceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DeviceType::class, 50)->create()->each(function ($deviceType) {
            $values = factory(DeviceType::class)->make();
    
            if (is_array($values)) {
                $deviceType->save($values);
            }
        });
    }
}
