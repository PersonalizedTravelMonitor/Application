<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrenordTripPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trenord_trip_parts', function (Blueprint $table) {
            $table->increments('id');

            $table->time('departure');
            $table->time('arrival');

            // the id of the train to follow, eg: 10846
            $table->string('trainId');
            // the line/directive of the train, eg: S8 or Milano-Lecco 
            $table->string('line'); 

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
        Schema::dropIfExists('trenord_trip_parts');
    }
}
