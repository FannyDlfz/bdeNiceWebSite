<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'            =>  $this->id,
            'text'          =>  $this->text,
            'like'          =>  $this->like,
            'created_at'    =>  $this->created_at,
            'updated_at'    =>  $this->updated_at
        ];
    }
}
