<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRupturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruptures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visite_id');
            $table->integer('product_id')->nullable();
            $table->string('product')->nullable();
            $table->boolean('autre')->default(false);
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
        Schema::dropIfExists('ruptures');
    }
}
