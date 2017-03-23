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
            $table->integer('documents2acl_id')->unsigned();
            $table->timestamp('datedoc')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('name');
            $table->string('identifier');
            $table->string('description');
            $table->string('filename');
            $table->integer('doctype_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->boolean('signed')->default(false);
            $table->boolean('readonly')->default(false);
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('documents');
    }
}
