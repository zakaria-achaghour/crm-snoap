<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReservedUgIdToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('ug_id')->nullable()->constrained()->onDelete('cascade');
            $table->boolean('reserved')->default(0);
            $table->boolean('is')->default(1);


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['is','reserved']);
            $table->dropConstrainedForeignId('ug_id');
            
        });
    }
}
