<?php

namespace App\Repositories\Contracts;

interface PostRepositoryInterface {

    public function all();
    public function store($input);
    public function get($input);
    public function update($input);
    public function destroy($input);
    public function isUserPost($input);
}
