<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([ //str_random(10)
        'name' => 'John Doe',
        'username' => 'JohnDoe',
        'email' => 'a@b.c',
        'password' => bcrypt('password'),
      ]);
    }
}
