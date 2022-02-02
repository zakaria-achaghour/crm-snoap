<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('network_id');
            $table->string('rubrique');
            $table->foreignId('doctor_id');
            $table->foreignId('nature_id');
            $table->string('nature_detail');
            $table->double('budget_prev',10,3);
            $table->decimal('tva',8,2)->nullable();
            $table->foreignId('month_id');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('step')->default(0);
            $table->double('budget_reel',10,3)->default(0);
            $table->integer('autre_user_id')->nullable();
            $table->integer('autre_doctor_id')->nullable();
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
        Schema::dropIfExists('advs');
    }
}
