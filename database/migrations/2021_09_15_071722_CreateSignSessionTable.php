<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_session', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->integer('sign_session_id')->nullable()->after('signed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sign_session');
        Schema::table('documents', function ($table) {
            $table->dropColumn('sign_session_id');
        });
    }
}
