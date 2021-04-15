<?php

namespace Database\Seeders;

use App\BusClass;
use Illuminate\Database\Seeder;

class BusClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        BusClass::insert([
            ['bus_class' => 'Ordinary'],
            ['bus_class' => 'Air Conditioned'],
            ['bus_class' => 'Deluxe'],
            ['bus_class' => 'Super Deluxe'],
        ]);
    }
}
