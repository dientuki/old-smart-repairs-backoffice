<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Le gato',
        ]);
        DB::table('users')->insert([
            'name' => 'Le tecnico',
        ]);
        DB::table('users')->insert([
            'name' => 'Le vendedor',
        ]);
    }
}
