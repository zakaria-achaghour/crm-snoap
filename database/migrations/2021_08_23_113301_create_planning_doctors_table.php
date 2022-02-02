<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('fait_par')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('datee_fin')->nullable();
            $table->boolean('done')->default(0);
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('visite_doctor_id')->nullable();

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
        Schema::dropIfExists('planning_doctors');
    }
}
