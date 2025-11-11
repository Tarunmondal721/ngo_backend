<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\Eventcontroller;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\DonationController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::prefix('/user')->group(function () {
    Route::get('/galleries', [GalleryController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/events', [Eventcontroller::class, 'index']);
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{slug}', [BlogController::class, 'findSlug']);
    Route::apiResource('contacts', ContactController::class);
    // Route::post('/event/register',[ContactController::class, 'eventRegister']);
    Route::post('/send-otp', [ContactController::class, 'sendOtp']);
    Route::post('/verify-otp', [ContactController::class, 'verifyOtp']);
    Route::post('/create-order', [DonationController::class, 'createOrder']);
    Route::post('/verify-payment', [DonationController::class, 'verifyPayment']);
    Route::post('/verifyotp', [ContactController::class, 'verify']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user', [AuthController::class, 'user']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('galleries', GalleryController::class);
    Route::apiResource('events', Eventcontroller::class);
    Route::apiResource('blogs', BlogController::class);
});
