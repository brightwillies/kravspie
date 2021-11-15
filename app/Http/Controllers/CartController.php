<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Cookie;
use Illuminate\Contracts\Cookie\Factory;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function Store(Request $request, Factory $cookie)
    {
        $message = "";

        $quantity = $request->quantity ?: 1;
        $product_id = $request->product_id;
        $findProduct = Product::find($product_id);

        if (empty($findProduct)) {
            return response()->json(['message' => 'Product not found']);
        }
        $identity = "";
        $userdata = session('loggedin');
        //if user is not logged in

        $tempid = Cookie::get('cus-shopping-id');

        if (isset($userdata)) {

            $product = Cart::where('product_id', $product_id)->where(function ($q) use ($userdata) {
                $q->where('customer_id', $userdata);
            })->first();
            if (!empty($product)) {
                $product->quantity += $quantity;
                $product->save();

                $message = $findProduct->name . "'s quantity has been updated";
            } else {

                $tempCart = new Cart();
                $tempCart->customer_id = $userdata;
                $tempCart->product_id = $product_id;
                $tempCart->quantity = $quantity;
                $tempCart->save();
            }

        } elseif (isset($tempid)) {

            $product = Cart::where('product_id', $product_id)->where(function ($q) use ($tempid) {
                $q->where('customer_id', $tempid);
            })->first();

            if (!empty($product)) {
                $product->quantity += $quantity;
                $product->save();

                $message = $findProduct->name . "'s quantity has been updated";
            } else {

                $tempCart = new Cart();
                $tempCart->customer_id = $tempid;
                $tempCart->product_id = $product_id;
                $tempCart->quantity = $quantity;
                $tempCart->save();

                $message = $findProduct->name . '  has been added to the cart';
            }

        } else {

            $tempid = rand(1111111, 9999999) . "_" . date('Y-m-d') . "_" . time();
            $cookie->queue($cookie->make('cus-shopping-id', $tempid, 129600));

            $tempCart = new Cart();
            $tempCart->customer_id = $tempid;
            $tempCart->product_id = $product_id;
            $tempCart->quantity = $quantity;
            $tempCart->save();
            $message = $findProduct->name . ' has been added to the cart';
        }

        $totalcartitems = Cart::where('customer_id', $userdata)->orwhere('customer_id', $tempid)->get();
        $total = Count($totalcartitems);

        $pro_image = $findProduct->image;

        $pro_name = $findProduct->name;

        return response()->json(['message' => $message, 'status' => 200, 'total' => $total, 'image' => $pro_image, 'pro_name' => $pro_name]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reduce(Request $request, Factory $cookie)
    {

        $cartId = $request->cart_id;
        $userdata = session('loggedin');
        //if user is not logged in

        $tempid = Cookie::get('cus-shopping-id');

        $tempCartProduct = Cart::where('id', $cartId)->where(function ($q) use ($userdata, $tempid) {
            $q->where('customer_id', $userdata)->orwhere('customer_id', $tempid);
        })->first();

        if (!empty($tempCartProduct)) {
            $quantity = $tempCartProduct->quantity;
            if ($quantity == 1) {
                $tempCartProduct->delete();
            } else {
                $tempCartProduct->quantity = $tempCartProduct->quantity - 1;
                $tempCartProduct->save();
            }
        }

        $message = 'Cart updated';
        return response()->json(['message' => $message, 'status' => 200]);

    }
    public function increase(Request $request, Factory $cookie)
    {

        $cartId = $request->cart_id;
        $userdata = session('loggedin');
        //if user is not logged in

        $tempid = Cookie::get('cus-shopping-id');

        $tempCartProduct = Cart::where('id', $cartId)->where(function ($q) use ($userdata, $tempid) {
            $q->where('customer_id', $userdata)->orwhere('customer_id', $tempid);
        })->first();

        if (!empty($tempCartProduct)) {
            $quantity = $tempCartProduct->quantity;

            $tempCartProduct->quantity = $tempCartProduct->quantity + 1;
            $tempCartProduct->save();

        }
        $message = 'Cart updated';
        return response()->json(['message' => $message, 'status' => 200]);

    }

    
}
