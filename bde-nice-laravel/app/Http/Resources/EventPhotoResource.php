<?php

namespace App\Http\Resources;

use App\Repositories\APIModelRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class EventPhotoResource extends JsonResource
{
    protected $userRepository;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->userRepository = new APIModelRepository('App\User', '/api/users');
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'name'          =>  $this->name,
            'like'          =>  $this->like,
            'description'   =>  $this->description,
            'user'          =>  $this->userRepository->find(array('id', $this->user_id))
        ];
    }
}
