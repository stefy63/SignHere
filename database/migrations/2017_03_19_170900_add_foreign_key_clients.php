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
        Schema::table('user_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('user_module', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('brand_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('brand_id')->references('id')->on('brands');
        });

        Schema::table('location_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('location_id')->references('id')->on('locations');
        });

        Schema::table('document_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('document_id')->references('id')->on('documents');
        });

        Schema::table('device_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('device_id')->references('id')->on('devices');
        });

        Schema::table('client_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls');
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('doctype_id')->references('id')->on('doctypes');
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
