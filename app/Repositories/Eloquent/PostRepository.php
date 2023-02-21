<?php

namespace App\Repositories\Eloquent;
use Auth;
use App\Models\Post;
use App\Exceptions\NotUserPost;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

    protected $model = Post::class;

    public function all(){
        return $this->model->all();
    }

    public function PostComments($id){
        $output = $this->model->find($id);
    }

    public function isUserPost($post){
        if(isset($post->user_id)){
            if(Auth::id() == $post->user_id){
                return true;
            }
        }

        throw new NotUserPost;
    }
}
