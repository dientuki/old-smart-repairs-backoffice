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
            'email' => 'maxxim@gmail.com',
        ]);
        DB::table('users')->insert([
            'name' => 'Le tecnico',
            'email' => 'maxxim-tech@gmail.com',
        ]);
        DB::table('users')->insert([
            'name' => 'Le vendedor',
            'email' => 'maxxim-sell@gmail.com',
        ]);
    }
}
