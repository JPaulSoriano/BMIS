<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Routes as RouteResource;

class ConductorRides extends JsonResource
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
            'ride_id' => $this->id,
            'bus_no' => $this->bus->bus_no,
            'departure_time' => $this->departure_time,
            'ride_date',
            'route' => new RouteResource($this->route),
            'employee_profile' => $this->bus->driver->employeeProfile,
        ];
    }
}
