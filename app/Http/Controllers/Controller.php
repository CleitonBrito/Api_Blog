<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
*
* @OA\Info(
*   version="1.0",
*   title="Api Blog",
*   description="Api para cadastrar posts e comentários, bem parecido com um blog.",
*   @OA\Contact(
*       name="Cleiton Brito",
*       email="cleytonbritto3003@gmail.com",
*       url="https://github.com/CleitonBrito"
*      )
* )
* @OA\Server(
*     url="http://localhost:8000/api/v1",
*     description="API server"
* )
* @OA\SecurityScheme(
*   type="http",
*   scheme="bearer",
*   securityScheme="bearerAuth",
* )
*
* ## Register User ##
*
* @OA\POST(
*   tags={"/users"},
*   path="/register",
*   description="Register new User",
*   security={{"bearerAuth": {}}},
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="name", type="string", format="binary", example="John Doe"),
*           @OA\Property(property="email", type="string", format="binary", example="johndoe@gmail.com"),
*           @OA\Property(property="password", type="string", format="binary", example="johndoe123"),
*           @OA\Property(property="password_confirmation", type="string", format="binary", example="johndoe123"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
* )
*
* ## Login with User ##
*
* @OA\POST(
*   tags={"/users"},
*   path="/login",
*   description="Login wiht User",
*   security={{"bearerAuth": {}}},
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="email", type="string", format="binary", example="johndoe@gmail.com"),
*           @OA\Property(property="password", type="string", format="binary", example="johndoe123"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
* )
*
* ## Logout User ##
*
* @OA\POST(
*   tags={"/users"},
*   path="/logout",
*   description="Logout current user",
*   security={{"bearerAuth": {}}},
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
* )
*
* ## Get All Posts ##
*
* @OA\Get(
*   tags={"/posts"},
*   path="/posts",
*   description="Get all posts",
*   security={{"bearerAuth": {}}},
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized")
* )
*
* ## Get Posts by Id ##
*
* @OA\Get(
*   tags={"/posts"},
*   path="/posts/{id}",
*   description="Get all posts",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Post id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
*
* ## Get All comments belongs to Post Id ##
*
* @OA\GET(
*   tags={"/posts"},
*   path="/posts/{id}/comments",
*   description="Get all comments belongs to Post Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Post id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Create Post ##
*
* @OA\POST(
*   tags={"/posts"},
*   path="/posts",
*   description="Create new posts",
*   security={{"bearerAuth": {}}},
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="title", type="string", format="binary", example="First Post"),
*           @OA\Property(property="content", type="string", format="binary", example="This is my first post"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
* )
*
* ## Update Post By Id ##
*
* @OA\PUT(
*   tags={"/posts"},
*   path="/posts/{id}",
*   description="Update post by Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Post id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="title", type="string", format="binary", example="Update my First Post"),
*           @OA\Property(property="content", type="string", format="binary", example="Now, post is updated."),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Delete Post By Id ##
*
* @OA\DELETE(
*   tags={"/posts"},
*   path="/posts/{id}",
*   description="Delete post by Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Post id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Get All Comments ##
*
* @OA\GET(
*   tags={"/comments"},
*   path="/comments",
*   description="Get all comments",
*   security={{"bearerAuth": {}}},
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized")
* )
*
* ## Get comment by Id ##
*
* @OA\GET(
*   tags={"/comments"},
*   path="/comments/{id}",
*   description="Get comment by Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Create Comment ##
*
* @OA\POST(
*   tags={"/comments"},
*   path="/comments",
*   description="Create new comment",
*   security={{"bearerAuth": {}}},
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="post_id", type="string", format="binary", example="1"),
*           @OA\Property(property="comment", type="string", format="binary", example="This is my first comment in post 1"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
* )
*
* ## Update Comment by Id ##
*
* @OA\PUT(
*   tags={"/comments"},
*   path="/comments/{id}",
*   description="Update Comment by Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="comment", type="string", format="binary", example="Update my first comment in post 1"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
* )
*
* ## Delete Comment by Id ##
*
* @OA\DELETE(
*   tags={"/comments"},
*   path="/comments/{id}",
*   description="Delete Comment by Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
* )
*
* ## Get Count Total Votes in Comment Id ##
*
* @OA\GET(
*   tags={"/comments"},
*   path="/comments/{id}/getCountVotes",
*   description="Get Count Total Votes in Comment Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Add Vote in Comment Id ##
*
* @OA\POST(
*   tags={"/comments"},
*   path="/comments/{id}/addOneVote",
*   description="Add Vote in Comment Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
* ## Subtract Vote in Comment Id ##
*
* @OA\POST(
*   tags={"/comments"},
*   path="/comments/{id}/subtractOneVote",
*   description="Subtract Vote in Comment Id",
*   security={{"bearerAuth": {}}},
*   @OA\Parameter(
*       description="Comment id",
*       in="path",
*       name="id",
*       example="1",
*       required=true,
*       @OA\Schema(
*           type="integer",
*           format="int64"
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized"),
*   @OA\Response(response=404, description="Not Found")
* )
*
*/


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
