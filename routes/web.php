<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::controller(ArticleController::class)->group(function () {
    Route::prefix('/api/article')->group(function () {
        Route::post('/', 'index');
        Route::get('/', 'store');
        Route::get('/{article}', 'show');
        Route::put('/{article}', 'update');
        Route::delete('/{article}', 'delete');
    });
});

Route::controller(VideoController::class)->group(function () {
    Route::prefix('/api/video')->group(function () {
        Route::post('/', 'index');
        Route::get('/', 'store');
        Route::get('/{video}', 'show');
        Route::put('/{video}', 'update');
        Route::delete('/{video}', 'delete');
    });
});

Route::controller(CommentController::class)->group(function () {
    Route::prefix('/api/comment')->group(function () {
        Route::post('/', 'index');
        Route::get('/', 'store');
        Route::get('/{current_comment}', 'show');
        Route::put('/{current_comment}', 'update');
        Route::delete('/{current_comment}', 'delete');
    });
});

Route::controller(UserController::class)->group(function () {
    Route::prefix('/api/user')->group(function () {
        Route::post('/', 'index');
        Route::get('/', 'store');
        Route::get('/{user}', 'show');
        Route::put('/{user}', 'update');
        Route::delete('/{user}', 'delete');
    });
});


