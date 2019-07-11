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
            'user_id' => 1,
            'active' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin',
            'username' => 'admin',
            'surname' => 'Superadmin',
            'email' => 'admin@localhost.com',
            'user_id'=> 1,
            'profile_id' => 1,
            'acl_id' => 1,
            'api_token' => str_random(60),
            'password' => bcrypt('admin'),
            'created_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('acl_user')->insert([
            'id' => 1,
            'acl_id' => 1,
            'user_id' => 1,
            'created_at' => new DateTime()
        ]);

        DB::table('profiles')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'user_id' => 1,
            'created_at' => new DateTime()
        ]);

        DB::table('acl_profile')->insert([
            'id' => 1,
            'acl_id' => 1,
            'profile_id' => 1,
            'created_at' => new DateTime()
        ]);

        DB::table('modules')->insert([
            'id' => 1,
            'name' => 'ACLs',
            'order' => 4,
            'short_name' => 'admin_acls',
            'functions' => 'index,create,show,edit,destroy,getitem',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 2,
            'name' => 'Brands',
            'order' => 1,
            'short_name' => 'admin_brands',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 3,
            'name' => 'Clients',
            'order' => 3,
            'short_name' => 'admin_clients',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 4,
            'name' => 'Devices',
            'order' => 11,
            'short_name' => 'admin_devices',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 5,
            'name' => 'Doc Type',
            'order' => 5,
            'short_name' => 'admin_doctypes',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 6,
            'name' => 'Documents',
            'order' => 6,
            'short_name' => 'admin_documents',
            'functions' => 'index,create,show,edit,destroy,update_file,import_file,export',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 7,
            'name' => 'Locations',
            'order' => 2,
            'short_name' => 'admin_locations',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 8,
            'name' => 'Modules',
            'order' => 10,
            'short_name' => 'admin_modules',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 9,
            'name' => 'Users',
            'order' => 8,
            'short_name' => 'admin_users',
            'functions' => 'index,create,show,edit,destroy,permission,resetPwd',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 10,
            'name' => 'Profiles',
            'order' => 9,
            'short_name' => 'admin_profiles',
            'functions' => 'index,create,show,edit,destroy',
            'isadmin' => true,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('modules')->insert([
            'id' => 11,
            'name' => 'Sign',
            'order' => 7,
            'short_name' => 'sign',
            'functions' => 'index,edit,create,destroy,signing,send,download',
            'isadmin' => false,
            'active' => 1,
            'user_id' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ]);




        DB::table('module_profile')->insert([
            'id' => 1,
            'profile_id' => 1,
            'module_id' => 1,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 2,
            'profile_id' => 1,
            'module_id' => 2,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 3,
            'profile_id' => 1,
            'module_id' => 3,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 4,
            'profile_id' => 1,
            'module_id' => 4,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 5,
            'profile_id' => 1,
            'module_id' => 5,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 6,
            'profile_id' => 1,
            'module_id' => 6,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 7,
            'profile_id' => 1,
            'module_id' => 7,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 8,
            'profile_id' => 1,
            'module_id' => 8,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 9,
            'profile_id' => 1,
            'module_id' => 9,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 10,
            'profile_id' => 1,
            'module_id' => 10,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        DB::table('module_profile')->insert([
            'id' => 11,
            'profile_id' => 1,
            'module_id' => 11,
            'permission' => 'ALL',
            'created_at' => date("Y-m-d H:i:s")
        ]);

    }
}
