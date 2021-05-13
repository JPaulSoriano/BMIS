<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingCodeToPassengerHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passenger_history', function (Blueprint $table) {
            $table->uuid('booking_code', 10)->after('id');
            $table->float('points')->default(0)->after('pax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passenger_history', function (Blueprint $table) {
            $table->dropColumn('booking_code');
            $table->dropColumn('points');
        });
    }
}
