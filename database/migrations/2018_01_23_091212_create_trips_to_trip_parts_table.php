<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsToTripPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips_to_trip_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('trip_id')->unsigned();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade'); 
            $table->integer('trip_part_id')->unsigned();
            $table->foreign('trip_part_id')->references('id')->on('trip_parts')->onDelete('cascade');    
   
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips_to_trip_parts');
    }
}
