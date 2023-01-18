<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('health', function(Request $request){
    return 'App health is good!';
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


Route::get('generate_storage', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Route::get('migrate', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate');
    echo 'ok';
});

Route::get('migrate_refresh', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate:refresh');
    echo 'ok';
});

Route::get('migrate_rollback', function (){
    \Illuminate\Support\Facades\Artisan::call('migrate:rollback');
    echo 'ok';
});

Route::get('make_migration', function (Request $request){
    if($request->has('name')){
        \Illuminate\Support\Facades\Artisan::call('make:migration' + '  ' + $request->name);
        echo 'ok';
    } else {
        echo 'Missing Name';
    }
});