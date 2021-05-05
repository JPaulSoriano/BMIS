<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartureArrivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departure_arrival', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_ride_id')->constrained('employee_ride')->onDelete('cascade');
            $table->foreignId('terminal_id')->constrained('terminals')->onDelete('cascade');
            $table->string('or_no');
            $table->enum('type', ['arrive', 'depart']);
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
        Schema::dropIfExists('departure_arrival');
    }
}
