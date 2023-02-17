<?php

use Illuminate\Http\Request;

Route::post('v1/login', 'api\v1\AuthController@login');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'middleware' => 'apiJwt'], function () {
    Route::post('logout', 'AuthController@logout');

    Route::apiResource('/posts', 'PostController');
    Route::group(['prefix' => 'posts' ], function () {
        Route::apiResource('{post}/comments', 'CommentController');
        Route::post('{post}/comments/{comment}/addOneVote', 'CommentController@addOneVote');
        Route::post('{post}/comments/{comment}/subtractOneVote', 'CommentController@subtractOneVote');
    });
});
