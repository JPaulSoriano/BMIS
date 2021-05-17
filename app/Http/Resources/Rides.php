<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Rides extends JsonResource
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
            'company_name' => $this->company->company_name,
            'ride_id' => $this->ride_id,
            'route_name' => $this->route->route_name,
            'bus_no' => $this->bus->bus_no,
            'bus_plate' => $this->bus->bus_plate,
            'bus_name' => $this->bus->bus_name,
            'bus_rate' => $this->bus->busClass->rate,
            'start_terminal' => $this->route->getTerminalNameById(request('start')),
            'end_terminal' => $this->route->getTerminalNameById(request('end')),
            'total_km' => $this->route->getTotalKm(request('start'), request('end')),
            'departure_time' => $this->departure_time_formatted,
            'bus_seat' => $this->bus->bus_seat,
            'booked_seats' => $this->booked_seats,
        ];
    }
}
