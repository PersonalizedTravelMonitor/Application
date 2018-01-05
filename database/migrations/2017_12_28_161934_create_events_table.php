<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('severity');  //TO DO: creare il tipo SeverityLevel

            // this will be used to store the type of the child (GenericInformationEvent, TravelerReportEvent) and its id on the corresponding table
            $table->integer('details_id')->unsigned();
            $table->string('details_type');

            $table->integer('trip_part_id')->unsigned();
            $table->foreign('trip_part_id')->references('id')->on('trip_parts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
