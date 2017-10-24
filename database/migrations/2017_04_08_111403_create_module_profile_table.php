<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned()->default(1);
            $table->integer('module_id')->unsigned()->default(1);
            $table->string('permission')->nullable()->default(null);
            $table->timestamps();
        });
        Schema::table('module_profile', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_profile');
    }
}
