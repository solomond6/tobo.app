<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('auth-user', [AuthUserController::class, 'show']);
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts/{post}/comment', [PostCommentController::class, 'store']);

Route::middleware('auth:api')->group(function () {

    // Route::get('auth-user', [AuthUserController::class, 'show']);

    // Route::apiResources([
    //     '/posts' => 'PostController',
    //     '/posts/{post}/like' => 'PostLikeController',
    //     '/posts/{post}/comment' => 'PostCommentController',
    //     '/users' => 'UserController',
    //     '/users/{user}/posts' => 'UserPostController',
    //     '/friend-request' => 'FriendRequestController',
    //     '/friend-request-response' => 'FriendRequestResponseController',
    //     '/user-images' => 'UserImageController',

    //     ]);

});


