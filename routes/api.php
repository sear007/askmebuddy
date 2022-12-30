<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('health', function(Request $request){
    return $request->header("secrectkey");
});

Route::middleware(['check_request'])->group(function() {
    Route::prefix('user')->group(function(){
        //Public Routes
        Route::post('login', [AuthUserController::class, 'login']);
        Route::post('register', [AuthUserController::class, 'register']);
        Route::post('google_oauth', [AuthUserController::class, 'googleOauthLogin']);
        //Authenticated Routes
        Route::middleware('auth:api')->group(function(){
            Route::post('update_user_profile', [UserController::class, 'updateUserProfile']);
            Route::post('logout', [AuthUserController::class, 'logout']);
        });
    });
});

