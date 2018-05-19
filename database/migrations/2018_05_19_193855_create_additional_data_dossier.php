<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionalDataDossier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_data_dossiers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dossier_id')->unsigned();
            $table->string('veicolo_targa')->nullable();
            $table->string('veicolo_marca')->nullable();
            $table->string('veicolo_modello')->nullable();
            $table->string('veicolo_allestimento')->nullable();
            $table->string('veicolo_cavalli_fiscali')->nullable();
            $table->string('veicolo_valore_assicurato')->nullable();
            $table->string('veicolo_stato_vaicolo')->nullable();
            $table->timestamp('veicolo_data_immatricolazione')->nullable();
            $table->string('veicolo_numero_telaio')->nullable();
            $table->string('contratto_polizza')->nullable();
            $table->string('contratto_societa')->nullable();
            $table->string('contratto_durata')->nullable();
            $table->string('contratto_importo')->nullable();
            $table->timestamp('contratto_data_scadenza_vincolo')->nullable();
            $table->timestamp('contratto_data_decorrenza')->nullable();
            $table->timestamp('contratto_data_scadenza')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('additional_data_dossiers');
    }
}
