<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\UserDetail;
use App\Models\Auth\User;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        //Insert Role
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'User',
        ]);
        Role::create([
            'name' => 'Support',
        ]);
        DB::table('users')->truncate();
        //Inser User 
        User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin1234'),
            'role_id' => 1,
            'isActive' => 1,
        ]);
        User::create([
            'email' => 'user@user.com',
            'password' => Hash::make('user1234'),
            'role_id' => 2,
            'isActive' => 1,
        ]);
        User::create([
            'email' => 'support@support.com',
            'password' => Hash::make('support1234'),
            'role_id' => 3,
            'isActive' => 1,
        ]);
        DB::table('user_details')->truncate();
        //Insert Details
        UserDetail::create([
            'email' => 'admin@admin.com',
            'first_name' => 'John',
            'last_name' => 'admin',
            'user_id' => 1,
        ]);
        UserDetail::create([
            'email' => 'user@user.com',

            'first_name' => 'John',
            'last_name' => 'User',
            'user_id' => 2,
        ]);
        UserDetail::create([
            'email' => 'support@support.com',
            'first_name' => 'John',
            'last_name' => 'Support',
            'user_id' => 3,
        ]);
    }
}
