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

    public function index(CommentRepositoryInterface $model){
        $outputs = $model->all();
        return response()->json(new CommentCollection($outputs));
    }

    public function get_count_votes_comment(CommentRepositoryInterface $model, $comment_id){
        return response()->json($model->get_count_votes_comment($comment_id));
    }

    public function addOneVote(CommentRepositoryInterface $model, $comment_id){
        return response()->json($model->addOneVote($comment_id));
    }

    public function subtractOneVote(CommentRepositoryInterface $model, $comment_id){
        return response()->json($model->subtractOneVote($comment_id));
    }
    
    public function store(CommentRepositoryInterface $model, CommentRequest $request){
        $data = [
            'post_id' => $request->post_id,
            'author_id' => Auth::id(),
            'comment' => $request->comment,
        ];

        $output = $model->store($data);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(202);
        return response()->json($output);
    }
    
    public function show(CommentRepositoryInterface $model, $comment_id){
        $output = $model->get($comment_id);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(404);
        return response()->json(new CommentResource($output));
    }

    public function update(CommentRepositoryInterface $model, Request $request, $comment_id){
        $output = $model->get($comment_id);
        $model->isUserComment($output);
        $data = [
            'id' => $comment_id,
            'comment' => $request->comment,
        ];
        return response()->json($model->update($data));
    }

    
    public function destroy(CommentRepositoryInterface $model, $comment_id){
        $output = $model->get($comment_id);
        $model->isUserComment($output);
        return response()->json($model->destroy($comment_id));
    }
}
