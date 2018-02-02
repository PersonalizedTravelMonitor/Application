<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelerReportEventsTable extends Migration
{
    /**
     * Run the migratons.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traveler_report_events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->text('message');
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
