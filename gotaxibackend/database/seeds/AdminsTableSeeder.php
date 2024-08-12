<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@meemcolart.com',
            'password' => Hash::make('Quartz@1234'),
            'status' => 1,
            'role_id' => 1
        ]);
    }
}
