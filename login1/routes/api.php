<?php

use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\PostController;
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

Route::get('/prova-api', function () {

    $user = [
        'name' => 'Emilio',
        'lastname' => 'Cellini'
    ];

    return response()->json($user);

});

Route::namespace('Api')
->prefix('posts')
->group(function () {
        Route::get('/post-category/{id}', [PostController::class, 'getPostsByCategory']);
        Route::get('/post-tag/{id}', [PostController::class, 'getPostsByTag']);
        Route::get('/{slug}', [PostController::class, 'getPostDetail']);
        Route::get('/search/{tosearch}', [PostController::class, 'search']);
        Route::get('/', [PostController::class, 'index']);
        Route::get('/categories', [PostController::class, 'getCategories']);
        Route::get('/tags', [PostController::class, 'getTags']);
});

//creo la rotta per le mail collegata al Leadcontroller
Route::post('/contacts', [LeadController::class, 'store']);