<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\CommentController;

Route::post('v1/login', 'api\v1\AuthController@login');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'middleware' => 'apiJwt'], function () {
    Route::post('logout', 'AuthController@logout');

    Route::apiResources([
        '/posts' => PostController::class,
        '/comments' => CommentController::class
    ]);

    Route::get('comments/{comment}/getCountVotes', 'CommentController@get_count_votes_comment');
    Route::post('comments/{comment}/addOneVote', 'CommentController@addOneVote');
    Route::post('comments/{comment}/subtractOneVote', 'CommentController@subtractOneVote');
});
