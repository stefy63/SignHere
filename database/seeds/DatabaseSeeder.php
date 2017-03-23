<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('acls')->insert([
            'id' => 1,
            'name' => 'root',
            'description' => 'root group of all acls',
            'parent_id' => 0,
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users2acls')->insert([
            'id' => 1,
            'acl_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'users2acl_id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'surname' => 'Superadmin',
            'email' => 'admin@localhost.com',
            'api_token' => str_random(60),
            'password' => bcrypt('admin'),
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users2modules')->insert([
            'id' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('modules')->insert([
            'name' => 'Administrator',
            'short_name' => 'admin',
            'functions' => 'index,create,show,edit,update,destroy',
            'users2module_id' => 1,
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);


    }
}
