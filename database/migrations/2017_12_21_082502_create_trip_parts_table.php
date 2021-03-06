<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_parts', function (Blueprint $table) {
            $table->increments('id');

            $table->text('from');
            $table->text('to');

            // this will be used to store the type of the child (TrenordTripPart, MetroTripPart) and its id on the corresponding table
            $table->integer('details_id')->unsigned();
            $table->string('details_type');

            // this is the parent trip that is made of smaller trip_parts (from Lecco to Milano Porta Garibaldi with Train + from Milano to Assago with Metro)
            $table->integer('trip_id')->unsigned();
            $table->foreign('trip_id')->references('id')->on('trips');

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
        Schema::dropIfExists('trip_parts');
    }
}
