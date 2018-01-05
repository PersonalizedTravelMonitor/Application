<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelerReportsEventsTable extends Migration
{
    /**
     * Run the migratons.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traveler_reports_events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            // TODO: improve the model with more details
            $table->string('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traveler_reports_events');
    }
}
