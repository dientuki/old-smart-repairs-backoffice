<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Seeder;

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
            'fk_account' => 1,
            'fk_user' => 1,
            'fk_rol' => 1,
            'is_owner' => true,
            'is_active' => true
        ]);
    }
}
