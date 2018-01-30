<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInternalIdToTrenordTripParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trenord_trip_parts', function (Blueprint $table) {
            $table->string('internalTrainId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trenord_trip_parts', function (Blueprint $table) {
            $table->dropColumn('internalTrainId');
        });
    }
}
