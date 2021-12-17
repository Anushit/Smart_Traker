<?php

namespace Database\Seeders;

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
        $data = new User();
        $data->name = 'admin';
        $data->username = 'admin';
        $data->email = 'admin@admin.com';
        $data->slug = 'admin';
        $data->type = 1;
        $data->password = Hash::make('12345678');
        $data->save();
    }
}
