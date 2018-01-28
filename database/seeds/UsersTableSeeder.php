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
        \App\User::create([
            'name'      => 'Luan Dantas',
            'username'  => 'luanhsd',
            'password'  => bcrypt('teste123'),
            'tel'       => '981813546',
            'email'     => 'luan_h.s.d@hotmail.com',
            'type'      => 1
        ]);
    }
}
