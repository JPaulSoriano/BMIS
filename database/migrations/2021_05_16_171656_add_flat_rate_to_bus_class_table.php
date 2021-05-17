<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlatRateToBusClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_classes', function (Blueprint $table) {
            $table->float('flat_rate')->default(0)->after('rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_classes', function (Blueprint $table) {
            $table->dropColumn('flat_rate');
        });
    }
}
