<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Superadmin\CategoryController;
use App\Http\Controllers\Superadmin\VendorController;
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
Route::prefix('superadmin')->group(function(){
    //For Suer admin currently no any auth middleware

    Route::prefix('public')->group(function(){
        Route::prefix('category')->group(function(){
            Route::get('/', [CategoryController::class, 'Categories']);
            Route::post('/store', [CategoryController::class, 'Store']);
        });
        Route::prefix('vendor')->group(function(){
            Route::get('/', [VendorController::class, 'Vendors']);
            Route::get('/{id}', [VendorController::class, 'Vendor']);
            Route::post('/update', [VendorController::class, 'Update']);
            Route::post('/store', [VendorController::class, 'Store']);
            Route::post('/delete/{id}', [VendorController::class, 'Destroy']);
        });
        Route::get('/search', [VendorController::class, 'Search']);
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

Route::get('cache_clear', function (){
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo 'Cache clear';
});

Route::get('config_cache', function (){
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    echo 'Cache clear';
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

Route::get('db_seed', function (Request $request){
    \Illuminate\Support\Facades\Artisan::call('db:seed');
    echo 'ok';
});