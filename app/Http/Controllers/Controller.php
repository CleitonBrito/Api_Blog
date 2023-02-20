<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
*
 * @OA\Info(
 *     version="1.0",
 *     title="Api Blog",
 *     description="Api para cadastrar posts e comentários, bem parecido com um blog.",
 *     @OA\Contact(name="Cleiton Brito")
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
*   @OA\Response(response=404, description="Not Found")
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
* @OA\POST(
*   tags={"/comments"},
*   path="/comments",
*   description="Get all comments",
*   security={{"bearerAuth": {}}},
*   @OA\RequestBody(
*       required=true,
*       @OA\JsonContent(      
*           type="object",
*           @OA\Property(property="post_id", type="number", format="binary", example="1"),
*       )
*   ),
*   @OA\Response(response=200, description="OK"),
*   @OA\Response(response=400, description="Bad Request"),
*   @OA\Response(response=403, description="Unauthorized")
* )
*
*/


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
