<?php

namespace App\Repositories\Eloquent;
use Auth;
use App\Models\Post;
use App\Models\UserCommentsVotes;
use App\Exceptions\NotUserPost;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Eloquent\CommentRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

    protected $model = Post::class;

    public function all(){
        return $this->model->all();
    }

    public function PostComments($id){
        try{
            $comments = $this->model->find($id)->comments;
            if($comments){
                foreach($comments as $comment){
                    $comment_votes = UserCommentsVotes::where('comment_id', $comment->id)->get();
                    if($comment_votes){
                        $count = 0;
                        foreach($comment_votes as $votes){
                            $count += intval($votes->vote);
                        }
                    }
                    $comment->votes = $count;
                }
                return $comments;
            }
            throw new NotUserPost;
        }catch(\Exception $e){
            return ['error_code' => $e->getMessage()];
        }
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
