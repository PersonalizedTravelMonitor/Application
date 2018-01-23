<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorIdToUserReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
     {
         Schema::table('traveler_report_events', function (Blueprint $table) {
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('traveler_report_events', function (Blueprint $table) {
             //
            $table->dropForeign('traveler_report_events_author_id_foreign');
            $table->dropColumn('author_id');
         });
     }
}
