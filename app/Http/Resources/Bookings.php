<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Rides as RideResource;

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
            'ride_id' => $this->ride_id,
            'company_name' => $this->ride->company->company_name,
            'booking_code' => $this->booking_code,
            'bus' => $this->ride->bus->bus_name,
            'bus_no' => $this->ride->bus->bus_no,
            'bus_plate' => $this->ride->bus->bus_plate,
            'route_name' => $this->ride->route->route_name,
            'distance' => $this->ride->route->getTotalKm($this->start_terminal_id, $this->end_terminal_id),
            'start_terminal' => $this->ride->route->getTerminalNameById($this->start_terminal_id),
            'end_terminal' => $this->ride->route->getTerminalNameById($this->end_terminal_id),
            'trip' => $this->ride->route->route_name,
            'time' => $this->ride->departure_time,
            'ride_date' => $this->travel_date,
            'pax' => $this->pax,
            'fare' => $this->sale->payment,
            'status' => $this->status,
            'aboard' => $this->aboard,
        ];
    }
}
