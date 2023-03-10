<?php

namespace App\Http\Controllers\Api\v1;

use Auth;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Comment\CommentCollection;
use App\Repositories\Contracts\PostRepositoryInterface;

use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function __construct(){
        return $this->middleware('apiJwt');
    }
    
    public function index(PostRepositoryInterface $model){
        $output = $model->all();
        return response()->json(new PostCollection($output));
    }

    public function store(PostRepositoryInterface $model, PostRequest $request){
        $data = [
            'user_id'=> Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content
        ];

        $output = $model->store($data);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(202);
        return response()->json($output);
    }

    public function show(PostRepositoryInterface $model, $id)
    {
        $output = $model->get($id);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(404);
        return response()->json(new PostResource($output));
    }

    public function commentsPost(PostRepositoryInterface $model, $id){
        $output = $model->PostComments($id);
        if(isset($output['error_code'])) return response()->json($output)->setStatusCode(404);
        return response()->json(new CommentCollection($output));
    }

    public function update(PostRepositoryInterface $model, Request $request, $id)
    {
        $output = $model->get($id);
        $model->isUserPost($output);
        $data = [
            'id' => $id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ];
        return response()->json($model->update($data));
    }

    public function destroy(PostRepositoryInterface $model, $id)
    {
        $output = $model->get($id);
        $model->isUserPost($output);
        return response()->json($model->destroy($id));
    }
    
}
