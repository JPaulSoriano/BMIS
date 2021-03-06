<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('bus_company_profiles')->onDelete('cascade');
            $table->foreignId('bus_class_id')->constrained('bus_classes')->onDelete('cascade');
            $table->string('bus_no');
            $table->string('bus_name');
            $table->string('bus_plate');
            $table->integer('bus_seat');
            $table->foreignId('conductor_id')->nullable();
            $table->foreignId('driver_id')->nullable();
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
        Schema::dropIfExists('buses');
    }
}
