<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id');
            $table->string('nom')->nullable();
            $table->string('intitulé')->nullable();
            $table->boolean('type')->nullable();
            $table->string('patente',50)->nullable();
            $table->string('ice',50)->nullable();
            $table->string('i_f',50)->nullable();
            $table->string('autorisation',50)->nullable();
            $table->string('rc',50)->nullable();
            $table->string('adresse',250)->nullable();
            $table->string('pharmacien',150)->nullable();
            $table->string('contact',50)->nullable();
            $table->string('cin',15)->nullable();
            $table->boolean('fichier_cin')->default(0);
            $table->boolean('fichier_diplome')->default(0);
            $table->boolean('fichier_autorisation')->default(0);
            $table->boolean('fichier_rc_patente')->default(0);
            $table->boolean('fichier_if_ice')->default(0);
            $table->boolean('statut')->default(1);
            $table->string('fichier',150)->nullable();
            $table->boolean('bloque')->default(0);
            $table->text('motif')->nullable();
            $table->string('sage',10)->nullable();
            $table->integer('updated_by');
            $table->foreignId('user_id');
            $table->foreignId('ville_id');
            $table->integer('nombreCheque')->nullable();

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
        Schema::dropIfExists('clients');
    }
}
