<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_location', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('acl_id')->unsigned()->default(1);
            $table->integer('location_id')->unsigned()->default(1);
            $table->timestamps();
        });
        Schema::table('acl_location', function (Blueprint $table) {
            $table->foreign('acl_id')->references('id')->on('acls')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acl_location');
    }
}

