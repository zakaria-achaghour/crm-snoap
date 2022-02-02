<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNbOrdonanceToVisiteDoctorEnquet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visite_doctor_enquet', function (Blueprint $table) {
            $table->integer('nb_ordonance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visite_doctor_enquet', function (Blueprint $table) {
            $table->dropColumn('nb_ordonance');
        });
    }
}
