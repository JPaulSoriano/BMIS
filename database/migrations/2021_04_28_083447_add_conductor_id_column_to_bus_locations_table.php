<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConductorIdColumnToBusLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_locations', function (Blueprint $table) {
            $table->foreignId('conductor_id')->constained('users')->onDelete('cascade')->after('ride_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_locations', function (Blueprint $table) {
            //
        });
    }
}
