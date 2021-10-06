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
        Schema::create('sign_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('dossier_id');
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->timestamps();
        });
        Schema::create('sign_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sign_session_id');
            $table->integer('document_id');
            $table->boolean('signed')->default(false);
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
        Schema::dropIfExists('sign_sessions');
        Schema::dropIfExists('sign_documents');
    }
}
