<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PassengerProfile extends JsonResource
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
            'user_name' => $this->user->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'contact' => $this->contact,
            'address' => $this->address,
            'user_name' => $this->user->name,
            'email' => $this->user->email,
            'points' => $this->points,
        ];
    }
}
