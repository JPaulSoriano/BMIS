<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Booking;
use App\Services\BookingService;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookingService = new BookingService();
        $bookings = Booking::all();
        $bookings->each(function ($book) use ($bookingService) {
            if (!$book->sale) {
                $book->sale()->create([
                    'rate' => $book->ride->bus->busClass->rate,
                    'payment' => $bookingService->computeFare($book->ride, $book->pax, $book->start_terminal_id, $book->end_terminal_id),
                ]);
            }
        });
    }
}
