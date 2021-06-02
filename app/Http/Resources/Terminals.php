<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class Terminals extends JsonResource
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
            'id' => $this->id,
            'terminal_name' => $this->terminal_name,
            'terminal_address' => $this->terminal_address,
            'order' => $this->pivot->order,
        ];
    }
}
