<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'Archi',
        	'email' => 'codenow2k@gmail.com',
        	'password' => bcrypt('codenow2k@gmail.com')
        ]);
    }
}
