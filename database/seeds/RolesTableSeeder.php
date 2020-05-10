<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'rol' => 'administrador',
        ]);
        DB::table('roles')->insert([
            'rol' => 'tecnico',
        ]);
        DB::table('roles')->insert([
            'rol' => 'vendedor',
        ]);
    }
}
