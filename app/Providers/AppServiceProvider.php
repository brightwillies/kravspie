<?php

namespace App\Providers;

use App\Models\Cart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //
        view()->composer('*', function ($view) {
            $tempID = Cookie::get('cus-shopping-id');
            $customerSessionID = Session::get('loggedin');
            $getTemporalCartProducts = Cart::where('customer_id', $tempID)->orWhere('customer_id', $customerSessionID)->get();

            $cartSum = 0;
            $productsTotal = 0;
            if ($getTemporalCartProducts->isNotEmpty()) {
                foreach ($getTemporalCartProducts as $key => $sCartItem) {
                    $cartSum = $cartSum + $sCartItem->subprice;
                    $productsTotal =  $productsTotal + $sCartItem->quantity;
                }
            }

            $view->with('cartSum', $cartSum);
            $view->with('cart_total', $productsTotal);
            $view->with('cartProducts', $getTemporalCartProducts);
        });
    }
}
