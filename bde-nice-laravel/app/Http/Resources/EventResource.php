<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'name'          =>  $this->name,
            'schedules'     =>  $this->scheduled,
            'recurrence'    =>  $this->recurrence,
            'price'         =>  $this->price,
            'description'   =>  $this->description,
            'begin_at'      =>  $this->begin_at,
            'end_at'        =>  $this->end_at
        ];
    }
}
