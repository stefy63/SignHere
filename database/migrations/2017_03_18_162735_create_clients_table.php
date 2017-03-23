<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clients2acl_id')->unsigned();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('vat');
            $table->string('personal_vat');
            $table->string('address');
            $table->string('city');
            $table->string('region');
            $table->string('zip_code');
            $table->string('contact');
            $table->string('phone');
            $table->string('mobile');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('clients');
    }
}