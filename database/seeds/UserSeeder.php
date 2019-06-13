<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'=>'Administrator',
            'email'=>'admin@example.com',
            'level'=>5,
            'password'=>bcrypt('admin')
        ]);
    }
}
