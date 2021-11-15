<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\OrderController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\FrontendController;
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

Route::post('/payment', [FrontendController::class, 'createPayment']);
Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/stats', [ProductController::class, 'statistics']);
        Route::group(['prefix' => 'usermanagement'], function () {


            Route::group(['prefix' => 'admin'], function () {
                Route::get('/', [UserController::class, 'indexAdmin']);
                Route::post('/', [UserController::class, 'storeAdmin']);
                Route::post('/{id}', [UserController::class, 'updateAdmin']);
                Route::delete('/{id}', [UserController::class, 'updateAdmin']);
            });
            Route::group(['prefix' => 'customers'], function () {
                Route::get('/', [UserController::class, 'customers']);
                Route::post('/', [UserController::class, 'storeAdmin']);
                Route::post('/{id}', [UserController::class, 'updateAdmin']);
                Route::delete('/{id}', [UserController::class, 'updateAdmin']);
            });
        });

        Route::group(['prefix' => 'orders'], function () {
            Route::get('/new', [OrderController::class, 'newOrders']);
            Route::get('/old', [OrderController::class, 'oldOrders']);
            Route::post('/update/{id}', [OrderController::class, 'updateOrder']);
        });

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::post('/', [CategoryController::class, 'store']);
            Route::post('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });
        Route::group(['prefix' => 'auth'], function () {
            Route::get('/{id}', [AdminAuthController::class, 'index']);
            Route::post('/update/{id}', [AdminAuthController::class, 'UpdateAdmin']);
            Route::post('/login', [AdminAuthController::class, 'Login']);
            Route::delete('/{id}', [AdminAuthController::class, 'destroy']);
        });
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::post('/{id}', [ProductController::class, 'Update']);
            Route::post('/', [ProductController::class, 'store']);
            Route::delete('/{id}', [ProductController::class, 'destroy']);
        });
    });
});
