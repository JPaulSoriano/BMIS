<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengerHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passenger_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade');
            $table->foreignId('passenger_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('start_terminal_id')->constrained('terminals')->onDelete('cascade');
            $table->foreignId('end_terminal_id')->constrained('terminals')->onDelete('cascade');
            $table->integer('pax')->default(1);
            $table->boolean('aboard')->default(0);
            $table->string('status')->default('new');
            $table->text('reason')->nullable();
            $table->date('travel_date');
            $table->float('points')->default(0);
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
        Schema::dropIfExists('passenger_history');
    }
}
