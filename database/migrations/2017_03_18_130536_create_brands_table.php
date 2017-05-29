<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('vat');
            $table->string('personal_vat')->nullable();
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

            $table->string('smtp_host', 100)->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_username',100)->nullable();
            $table->string('smtp_password',100)->nullable();

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
        Schema::dropIfExists('acl_brand');
        Schema::dropIfExists('brands');
    }
}
