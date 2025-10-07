<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Eventcontroller;
use App\Http\Controllers\Api\GalleryController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::prefix('/user')->group(function(){
    Route::get('/galleries',[GalleryController::class,'index']);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/events',[Eventcontroller::class,'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user', [AuthController::class, 'user']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('galleries', GalleryController::class);
    Route::apiResource('events', Eventcontroller::class);
});
