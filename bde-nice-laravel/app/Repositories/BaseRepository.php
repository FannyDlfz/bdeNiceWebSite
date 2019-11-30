<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository {

    protected $model;

    public function getPaginate($n) {
        return $this->model->paginate($n);
    }

    public function store(Array $inputs) {
        return $this->model->create($inputs);
    }

    public function getById($id) {
        return $this->model->findOrFail($id);
    }

    public function update($id, Array $inputs) {
        $this->getById($id)->fill($inputs)->save();
        return $this->getById($id);
    }

    public function destroy($id) {
        $this->getById($id)->delete();
    }

}
