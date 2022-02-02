<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('phone')->nullable();
            $table->foreignId('ville_id');
            $table->foreignId('region_id');
            $table->foreignId('ug_id');
            $table->foreignId('specialty_id');
            $table->integer('nombre_patients')->default(0);
            $table->text('adresse')->nullable();
            $table->boolean('statut')->default(1);
            $table->string('motif')->nullable();
            $table->string('statut_mc')->nullable();
            $table->integer('ug_mc')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('doctors');
    }
}
