<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logins')->insert([
            'username' => 'maxxim',
            'password' => Hash::make('password'),
            'fk_user' => 1,
            'is_active' => 1,
        ]);
        DB::table('logins')->insert([
            'username' => 'maxxim-tech',
            'password' => Hash::make('password'),
            'fk_user' => 2,
            'is_active' => 1,
        ]);
        DB::table('logins')->insert([
            'username' => 'maxxim-sell',
            'password' => Hash::make('password'),
            'fk_user' => 3,
            'is_active' => 1,
        ]);
    }
}
