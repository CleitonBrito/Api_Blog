<?php

namespace App\Repositories\Eloquent;
use Auth;
use DB;
use App\Models\Comment;
use App\Exceptions\NotUserComment;
use App\Exceptions\UserIsOwnerFromComment;
use App\Repositories\Contracts\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface {

    protected $model = Comment::class;

    public function findAllCommentsBlongsToPost($post_id){
        if($post_id !== null)
            return DB::select('select * from comments where post_id = ?', [$post_id]);
        else
            return ['error' => 'Param post_id not found in request.'];
    }

    public function addOneVote($id){
        try{
            $comment = $this->model->findOrFail($id);

            if($comment->author_id == Auth::id()){
                throw new UserIsOwnerFromComment;
            }

            $comment
                ->where('id', $comment->id)
                ->update([
                    'vote' => $comment->vote + 1
            ]);
            return "vote successfully added!";

        }catch(\PDOException $e){
            return ['error_code' => $e->getCode()];
        }
    }

    public function subtractOneVote($id){
        try{
            $comment = $this->model->findOrFail($id);

            if($comment->author_id == Auth::id()){
                throw new UserIsOwnerFromComment;
            }

            $comment
                ->where('id', $comment->id)
                ->update([
                    'vote' => $comment->vote - 1
            ]);
            return "vote successfully subtracted!";

        }catch(\PDOException $e){
            return ['error_code' => $e->getCode()];
        }
    }

    public function isUserComment($comment){
        if(isset($comment->author_id)){
            if(Auth::id() == $comment->author_id){
                return true;
            }
        }

        throw new NotUserComment;
    }
}
