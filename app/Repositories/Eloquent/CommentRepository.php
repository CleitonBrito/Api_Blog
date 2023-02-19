<?php

namespace App\Repositories\Eloquent;
use Auth;
use DB;
use App\Models\Comment;
use App\Models\UserCommentsVotes;
use App\Exceptions\NotUserComment;
use App\Exceptions\UserIsOwnerFromComment;
use App\Exceptions\UserCannotVoteInYourComment;
use App\Repositories\Contracts\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface {

    protected $model = Comment::class;

    public function get_user_comment_votes($comment_id){
        $output = $this->model->find($comment_id);
        if($output){
            $output->users_comments_votes->where('user_id',  Auth::id())->first();
            return $output;
        }
    }

    public function findAllCommentsBlongsToPost($post_id){
        if($post_id !== null)
            return DB::select('select * from comments where post_id = ?', [$post_id]);
        else
            return ['error' => 'Param post_id not found in request.'];
    }

    public function addOneVote($comment_id){
        try{
            $votes = $this->get_user_comment_votes($comment_id)->users_comments_votes[0];

            if($votes){
                if($votes->author_id == Auth::id()){
                    throw new UserCannotVoteInYourComment;
                }

                if($votes->vote == "-1"){
                    $votes->vote = "1";
                    if ($votes->save())
                        return "Voto adicionado";
                }
                else if ($votes->vote == "0"){
                    $votes->vote = "1";
                    if ($votes->save())
                        return "Voto adicionado";
                }
                else if ($votes->vote == "1"){
                    $votes->vote = "0";
                    if ($votes->save())
                        return "Voto removido";
                }
            }
        }catch(\Exception $e){
            $comment = $this->model->find($comment_id);
            if($comment){
                try{
                    UserCommentsVotes::create([
                        'comment_id' => $comment_id,
                        'user_id' => Auth::id(),
                        'vote' => "1"
                    ]);
                    return "Voto adicionado";
                }catch(\Exception $e){
                    return ['error_code' => $e->getCode()];
                }
            }else{
                throw new NotUserComment;
            }
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
