<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_doc')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('name');
            $table->string('identifier')->nullable();
            $table->string('description')->nullable();
            $table->string('filename');
            $table->integer('doctype_id')->unsigned();
            $table->integer('dossier_id')->unsigned();
            $table->boolean('signed')->default(false);
            $table->boolean('readonly')->default(false);
            $table->integer('user_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('dossier_id')->references('id')->on('dossiers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
