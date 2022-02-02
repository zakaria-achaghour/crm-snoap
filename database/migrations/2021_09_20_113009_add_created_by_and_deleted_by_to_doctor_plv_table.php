<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByAndDeletedByToDoctorPlvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_plv', function (Blueprint $table) {
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_plv', function (Blueprint $table) {
            $table->dropColumn(['created_by','deleted_by']);
        });
    }
}
