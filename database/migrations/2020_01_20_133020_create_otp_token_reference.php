<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpTokenReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_otps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 60);
            $table->integer('user_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('phone', 20);
            $table->integer('document_id')->unsigned();
            $table->boolean('signed')->default(false);
            $table->string('otp', 10);
            $table->timestamp('expired_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_otps');
    }
}
