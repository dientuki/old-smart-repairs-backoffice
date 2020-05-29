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
        factory(Device::class, 50)->create()->each(function ($device) {
            $values = factory(Device::class)->make();
    
            if (is_array($values)) {
                $device->save($values);
            }
        });
    }
}
