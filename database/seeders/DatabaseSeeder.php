<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();

        //CREATE STATIC ROLES
        Roles::insert([
            [
                //id: 1
                'name' => 'Admin',
                'description' => 'User with all application privileges',
                'code' => 'A'
            ],
            [
                //id: 2
                'name' => 'User',
                'description' => 'User with limited privileges',
                'code' => 'U'
            ],
        ]);

        //CREATE AND ADMIN USER
        User::insert(
            [
                'roles_id' =>  1, //admin role id
                'name' =>  'admin', //default name
                'email' => 'admin@admin.com', //default email
                'email_verified_at' => date("Y/m/d"), //verified today
                'created_at' => date("Y/m/d"), //created today
                'password' => Hash::make('admin123') //default admin password: admin123
            ]
        );

        //CREATE SOME USER
        User::insert(
            [
                'roles_id' =>  2, //user role id
                'name' =>  'fer mar', //default name
                'email' => 'ferchito.marles@gmail.com', //default email
                'email_verified_at' => date("Y/m/d"), //verified today
                'created_at' => date("Y/m/d"), //created today
                'password' => Hash::make('fernando') //default admin password: admin123
            ]
        );

        Product::factory(100)->create();
    }
}
