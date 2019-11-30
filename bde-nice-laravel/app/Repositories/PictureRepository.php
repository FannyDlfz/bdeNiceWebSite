<?php

namespace App\Repositories;

use App\Picture;

class PictureRepository extends BaseRepository {
    protected $picture;

    public function __construct(Picture $picture) {
        $this->model=$picture;
    }
}
