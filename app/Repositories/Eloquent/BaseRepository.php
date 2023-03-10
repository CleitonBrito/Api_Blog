<?php

namespace App\Repositories\Eloquent;

abstract class BaseRepository {

    protected $model;

    public function __construct(){
        $this->model = $this->resolveModel();
    }

    protected function resolveModel(){
        return app($this->model);
    }

    public function store($input){
        try{
            $this->model->create($input);
            return class_basename($this->model)." saved successfully!";
        }catch(\Exception $e){
            return ['error_code' => $e->getCode()];
        }
    }

    public function get($id){
        try{
            $output = $this->model::findOrFail($id);
            return $output;
        }catch(\Exception $e){
            return ['error_code' => $e->getCode()];
        }
    }

    public function update($input){
        try{
            $input = array_filter($input);
            $this->model->where('id', $input['id'])->update($input);
            return class_basename($this->model)." successfully updated!";
        }catch(\Exception $e){
            return ['error_code' => $e->getCode()];
        }
    }

    public function destroy($input){
        try{
            $this->model->destroy($input);
            return class_basename($this->model). " successfully deleted!";
        }catch(\Exception $e){
            return ['error_code' => $e->getCode()];
        }
    }
}