<?php

namespace App\Http\Controllers\Api\v1;

use Auth;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\Controller;

use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Repositories\Contracts\CommentRepositoryInterface;

use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

    public function __construct(){
        return $this->middleware('apiJwt');
    }

    public function index(CommentRepositoryInterface $model, $posts_id){
        $output = $model->findAllCommentsBlongsToPost($posts_id);
        return response()->json($output);
    }

    public function addOneVote(CommentRepositoryInterface $model, $post_id, $comment_id){
        return response()->json($model->addOneVote($comment_id));
    }

    public function subtractOneVote(CommentRepositoryInterface $model, $post_id, $comment_id){
        return response()->json($model->subtractOneVote($comment_id));
    }
    
    public function store(CommentRepositoryInterface $model, CommentRequest $request, $post_id){
        $data = [
            'post_id' => $post_id,
            'author_id' => Auth::id(),
            'comment' => $request->comment,
        ];

        $output = $model->store($data);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(202);
        return response()->json($output);
    }
    
    public function show(){
        
    }

    public function update(CommentRepositoryInterface $model, CommentRequest $request, $post_id, $comment_id){
        $output =  $model->get($comment_id);
        $model->isUserComment($output);
        $data = [
            'id' => $comment_id,
            'comment' => $request->comment,
        ];
        return response()->json($model->update($data));
    }

    
    public function destroy(){
        
    }
}
