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
        /* Schema::table('user_acl', function (Blueprint $table) {
             $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         });

        Schema::table('user_module', function (Blueprint $table) {
             $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         });

        Schema::table('brand_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });

        Schema::table('location_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });

        Schema::table('document_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });

        Schema::table('device_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });

        Schema::table('client_acl', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::table('module_profile', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });*/
        /*
                Schema::table('documents', function (Blueprint $table) {
                    $table->foreign('client_id')->references('id')->on('clients');
              });
                /*
                Schema::table('locations', function (Blueprint $table) {
                    $table->foreign('brand_id')->references('id')->on('brands');
                });
                */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acl_user');
        Schema::dropIfExists('module_user');
        Schema::dropIfExists('acl_brand');
        Schema::dropIfExists('acl_location');
        Schema::dropIfExists('acl_document');
        Schema::dropIfExists('acl_device');
        Schema::dropIfExists('acl_client');
        Schema::dropIfExists('acl_profile');
        Schema::dropIfExists('acl_module');

        Schema::dropIfExists('documents');
        Schema::dropIfExists('locations');

    }
}
