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

        Schema::table('module_profile', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('client_id')->references('id')->on('clients');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_acl');
        Schema::dropIfExists('user_module');
        Schema::dropIfExists('brand_acl');
        Schema::dropIfExists('location_acl');
        Schema::dropIfExists('document_acl');
        Schema::dropIfExists('device_acl');
        Schema::dropIfExists('client_acl');

        Schema::dropIfExists('documents');
        Schema::dropIfExists('locations');

    }
}
