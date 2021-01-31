<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name' => 'Arnob',
            'last_name' => 'Khan',
            'email' => 'arnobkhan372@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456')
        ]);
    }
}
