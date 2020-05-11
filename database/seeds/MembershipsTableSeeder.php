<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'account_id' => 1,
            'user_id' => 1,
            'rol_id' => 1,
            'is_owner' => true,
            'is_active' => true
        ]);
    }
}
