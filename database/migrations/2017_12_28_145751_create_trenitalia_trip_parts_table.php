<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrenitaliaTripPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trenitalia_trip_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->time('departure');
            $table->time('arrival');

            // the id of the train to follow, eg: 10846
            $table->string('trainId');
            // the platform used at the departure station
            $table->string('departurePlatform'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trenitalia_trip_parts');
    }
}
