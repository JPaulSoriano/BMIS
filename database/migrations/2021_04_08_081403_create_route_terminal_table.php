<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteTerminalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_terminal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id');
            $table->foreignId('terminal_id');
            $table->integer('order');
            $table->integer('minutes_from_departure')->nullable();
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
        Schema::dropIfExists('route_terminal');
    }
}
