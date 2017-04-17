<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('sector')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zip_code')->nullable();
            $table->string('region');
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('email');
            $table->integer('user_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('locations');
    }
}
