<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Terminals as TerminalResource;

class Routes extends JsonResource
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
            'route_name' => $this->route_name,
            'terminals' => TerminalResource::collection($this->terminals),
        ];
    }
}
