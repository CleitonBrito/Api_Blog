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

    public function get_count_votes_comment($comment_id){
        try{
            $comment_votes = $this->model->find($comment_id)->users_comments_votes;
            $count = 0;
            if($comment_votes){
                foreach($comment_votes as $votes){
                    $count += intval($votes->vote);
                }
            }
            return ['comment_id' => $comment_id, 'total_votes' => $count];
        }catch(\Exception $e){
            throw new NotUserComment;
        }
    }

    public function all(){
        $comments = $this->model->all();
        foreach($comments as $comment){
                $comment->votes = $this->get_count_votes_comment($comment->id)['total_votes'];
            }
        return $comments;
    }

    public function get($id){
        if($id !== null){
            $output = parent::get($id);
            if(!isset($output['error_code'])){
                $output['votes'] = $this->get_count_votes_comment($output['id'])['total_votes'];
            }
            return $output;
        }
    }

    public function get_user_comment_votes($comment_id){
        $output = $this->model->find($comment_id);
        if($output){
            $output->users_comments_votes->where('user_id',  Auth::id())->first();
            return $output;
        }
    }

    public function findAllCommentsBlongsToPost($post_id){
        if($post_id !== null){
            $comments = DB::select('select * from comments where post_id = ?', [$post_id]);
            foreach($comments as $comment){
                $comment->votes = $this->get_count_votes_comment($comment->id)['total_votes'];
            }
            return $comments;
        }else
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
                        return "Like vote added";
                }
                else if ($votes->vote == "0"){
                    $votes->vote = "1";
                    if ($votes->save())
                        return "Like vote added";
                }
                else if ($votes->vote == "1"){
                    $votes->vote = "0";
                    if ($votes->save())
                        return "Like vote removed";
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
                    return "Like vote added";
                }catch(\Exception $e){
                    return ['error_code' => $e->getCode()];
                }
            }else{
                throw new NotUserComment;
            }
        }
    }

    public function subtractOneVote($comment_id){
        try{
            $votes = $this->get_user_comment_votes($comment_id)->users_comments_votes[0];

            if($votes){
                if($votes->author_id == Auth::id()){
                    throw new UserCannotVoteInYourComment;
                }

                if($votes->vote == "-1"){
                    $votes->vote = "0";
                    if ($votes->save())
                        return "No Like vote removed";
                }
                else if ($votes->vote == "0"){
                    $votes->vote = "-1";
                    if ($votes->save())
                        return "No Like vote added";
                }
                else if ($votes->vote == "1"){
                    $votes->vote = "-1";
                    if ($votes->save())
                        return "No Like vote added";
                }
            }
        }catch(\Exception $e){
            $comment = $this->model->find($comment_id);
            if($comment){
                try{
                    UserCommentsVotes::create([
                        'comment_id' => $comment_id,
                        'user_id' => Auth::id(),
                        'vote' => "-1"
                    ]);
                    return "No Like vote added";
                }catch(\Exception $e){
                    return ['error_code' => $e->getCode()];
                }
            }else{
                throw new NotUserComment;
            }
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
