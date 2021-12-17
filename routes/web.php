<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/email-registeration', function () {
    $data = array(
        'name' => 'Bright',
        'email' => 'bwboakye@gmail.com',
    );

    return view('emails.order')->with('data', $data);
});
Route::get('/order-placed', function () {
    return view('thankyou');
});
Route::get('/policy', function () {
    return view('policy');
});
Route::get('/terms', function () {
    return view('terms');
});
Route::post('/payment', [FrontendController::class, 'createPayment']);

Route::get('/login-register', function () {
    return view('auth');
})->name('authentication');

Route::get('/logout', [FrontendController::class, 'logout']);

Route::get('/contact-us', function () {
    return view('contact');
});
Route::group(['prefix' => 'cart'], function () {
    Route::post('/', [CartController::class, 'store']);
    Route::post('/reduce', [CartController::class, 'reduce']);
    Route::post('/increase', [CartController::class, 'increase']);
    Route::get('/get-cart-table', [CartController::class, 'getCartTable'])->name('getTable');

});

Route::get('/try-an-order-mail', [FrontendController::class, 'trymail']);
Route::get('/fogot-password', [CustomerController::class, 'forgetpass']);

Route::group(['prefix' => 'customer'], function () {
    Route::post('/register', [CustomerController::class, 'register']);
    Route::post('/login', [CustomerController::class, 'login']);
    Route::post('/increase', [CustomerController::class, 'increase']);
    Route::post('/forgot-password', [CustomerController::class, 'forgotPassword']);
});

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/products/{id}', [FrontendController::class, 'singleproduct']);
Route::get('/categories/{id}', [FrontendController::class, 'categoryproducts']);
Route::get('/about-us', [FrontendController::class, 'about']);
Route::get('/my-cart', [FrontendController::class, 'cart']);
Route::get('/checkout', [FrontendController::class, 'checkout']);
Route::get('/shop', [FrontendController::class, 'shop']);

Route::post('/payment', [FrontendController::class, 'createPayment']);
Route::get('/admin-login', [DashboardController::class, 'admin']);
Route::get('/admin-forgot-password', [DashboardController::class, 'admin']);
Route::get('/admin-dashboard', [DashboardController::class, 'admin']);
Route::get('/admin-dashboard/{any?}', [DashboardController::class, 'admin']);
Route::get('/admin-dashboard/product/{any?}', [DashboardController::class, 'admin']);
