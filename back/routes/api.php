<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterAuth;
use App\Http\Controllers\LogoutAuth;
use App\Http\Controllers\LoginAuth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reset;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;



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

Route::post('/auth/register', [RegisterAuth::class, 'regist']);
Route::post('/auth/login', [LoginAuth::class, 'login']);
Route::post('/auth/reset', [Reset::class, 'reset']);
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{title}', [PostsController::class, 'post_search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users', [Controller::class, 'index']);
    Route::post('/auth/logout', [LogoutAuth::class, 'logout']);
    /*************************************************** */
    Route::get('/users/{login}', [UserController::class, 'search']);
    Route::post('/users/avatar', [UserController::class, 'updateProfile']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/{login}/avatar', [UserController::class, 'searchPic']);
    /*************************************************** */
    Route::post('/categories', [CategoriesController::class, 'create_categorie']);
    Route::patch('/categories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy']);
    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/{title}', [CategoriesController::class, 'cat_search']);
    Route::get('/categories/{title}/posts', [CategoriesController::class, 'get_cat_post']);
    /*************************************************** */
    Route::post('/posts', [PostsController::class, 'create_post']);
    Route::patch('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
    Route::get('/posts/{title}/categories', [PostsController::class, 'get_post_cat']);
    Route::post('/posts/{id}/comments', [CommentsController::class, 'create_comment']);
    Route::get('/posts/{id}/comments', [CommentsController::class, 'get_comm_spec_post']);
    Route::post('/posts/{id}/like', [LikesController::class, 'create_like_post']);
    Route::get('/posts/{id}/like', [LikesController::class, 'get_like_un_post']);
    Route::delete('/posts/{id}/like', [LikesController::class, 'destroy_like_post']);
    /*************************************************** */
    Route::get('/comments/{id}', [CommentsController::class, 'comment_search']);
    Route::patch('/comments/{id}', [CommentsController::class, 'update']);
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy']);
    Route::post('/comments/{id}/like', [LikesController::class, 'create_like_comment']);
    Route::get('/comments/{id}/like', [LikesController::class, 'get_like_un_comment']);
    Route::delete('/comments/{id}/like', [LikesController::class, 'destroy_like_comment']);
});
