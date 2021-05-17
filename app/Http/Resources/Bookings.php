<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Bookings extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'points' => $this->points,
            'booking_code' => $this->booking_code,
            'bus' => $this->ride->bus->bus_name,
            'trip' => $this->ride->route->route_name,
            'time' => $this->ride->departure_time,
            'ride_date' => $this->travel_date,
            'pax' => $this->pax,
            'fare' => $this->sale->payment,
            'status' => $this->status,
        ];
    }
}
