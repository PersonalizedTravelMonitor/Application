<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtmTripPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atm_trip_parts', function (Blueprint $table) {
            $table->increments('id');

            // the line/directive of the subway es "Verde"
            $table->string('line');
            //  the type of veicle used es "Bus, Metro, Tram"
            $table->string('vehicleType');
            // number of stops between departure and arrival
            $table->integer('stopsNumber');

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
        Schema::dropIfExists('atm_trip_parts');
    }
}
