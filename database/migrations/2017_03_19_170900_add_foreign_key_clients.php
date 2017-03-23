<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('users2acl_id')->references('id')->on('users2acls')->onDelete('cascade');
        });

        Schema::table('users2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->foreign('users2module_id')->references('id')->on('users2modules')->onDelete('cascade');
        });

        Schema::table('users2modules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('brands2acl_id')->references('id')->on('brands2acls')->onDelete('cascade');
        });

        Schema::table('brands2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('locations2acl_id')->references('id')->on('locations2acls')->onDelete('cascade');
        });

        Schema::table('locations2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('doctype_id')->references('id')->on('doctypes');
            $table->foreign('documents2acl_id')->references('id')->on('documents2acls')->onDelete('cascade');
        });

        Schema::table('documents2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('clients2acl_id')->references('id')->on('clients2acls')->onDelete('cascade');
        });

        Schema::table('clients2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });


        Schema::table('devices', function (Blueprint $table) {
            $table->foreign('devices2acl_id')->references('id')->on('devices2acls')->onDelete('cascade');
        });

        Schema::table('devices2acls', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
