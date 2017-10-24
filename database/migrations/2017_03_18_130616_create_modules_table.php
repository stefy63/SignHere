<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name');
            $table->string('functions');
            $table->string('icon')->default('fa fa-th-large')->nullable();
            $table->boolean('isadmin')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('user_id')->unsigned();
            $table->integer('order')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acl_module');
        Schema::dropIfExists('modules');
    }
}
