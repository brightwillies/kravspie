<?php

namespace App\Http\Controllers;

use App\Mail\PurchaseConfirmation;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
// use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Square\Environment;
use Square\SquareClient;
use stdClass;

class FrontendController extends Controller
{
    public function categoryproducts($id)
    {
        $products = Product::where('category_id', $id)->get();
        $categories = Category::all();

        return view('shop', compact('products', 'categories'));
    }
    //
    public function logout()
    {
        Session::flush();

        $redirect = '/';
        return redirect($redirect);
    }

    public function singleproduct($id)
    {

        $product = Product::find($id);
        $products = Product::all();
        return view('singleproduct', compact('product', 'products'));
    }
    public function about()
    {
        return view('about');
    }
    public function shop()
    {

        $categories = Category::all();
        $products = Product::all();
        return view('shop', compact('products', 'categories'));
    }

    public function createPayment(Request $request)
    {
        //   $today = strtotime('today');
        // return date("M d", $today);

        $itemsreceived = $request->items;
        $items = explode(',', $itemsreceived);

        $customerSessionID = Session::get('loggedin');

        $findCustomer = Customer::where('mask', $customerSessionID)->first();

        $pickupdate = $request->pickupdate;
        $pickuptime = $request->pickuptime;

        $amount = $request->amount;
        $client = new SquareClient([
            'accessToken' => 'EAAAEHysWwv1SNJvAja_QgpsBvmHDpg9PLgrX1Sztx1XRvELCpvMiI62ivo6JDHb',
            'environment' => Environment::SANDBOX,
        ]);
        $amount_money = new \Square\Models\Money();
        $amount_money->setAmount($amount);
        $amount_money->setCurrency('USD');

        $body = new \Square\Models\CreatePaymentRequest(
            $request->sourceId,
            generate_mask(),
            $amount_money
        );
        $body->setAcceptPartialAuthorization(false);

        $api_response = $client->getPaymentsApi()->createPayment($body);

        if ($api_response->isSuccess()) {

            //save order items
            $newOrder = new Order();
            $newOrder->customer_id = $customerSessionID;
            $newOrder->number_of_items = count($items);
            $newOrder->pickupdate = $pickupdate;
            $newOrder->pickuptime = $pickuptime;
            $newOrder->amount = $amount;
            $newOrder->placed_on = gmdate('Y-m-d H:i:s');
            $newOrder->mask = generate_mask();
            if ($newOrder->save()) {

                $emailArray = array();
                //save order items
                foreach ($items as $key => $sItem) {
                    $emailProduct = new stdClass();

                    // $person=new stdClass();

                    $findProduct = Product::find($sItem[0]);

                    $emailProduct->name = $findProduct->name;
                    $emailProduct->quantity = $sItem[2];
                    $emailProduct->totalprice = ($sItem[2] * $findProduct->price);
                    $emailArray[] = $emailProduct;

                    $newItems = new OrderItem();
                    $newItems->order_id = $newOrder->id;
                    $newItems->product_id = $sItem[0];
                    $newItems->quantity = $sItem[2];
                    $newItems->mask = generate_mask();
                    $newItems->price = $findProduct->price;
                    $newItems->total_amount = ($sItem[2] * $findProduct->price);
                    $newItems->save();
                }
                $data = array(
                    'items' => $emailArray,
                    'name' => $findCustomer->first_name . ' ' . $findCustomer->last_name,
                    'orderid' => $newItems->mask,
                    'cost' => $amount,
                    'pickupdate' => $pickupdate . ',' . now()->year,
                );

                try {

                    $mail = Mail::to($findCustomer->email)->send(new PurchaseConfirmation($data));

                } catch (\Throwable $th) {
                    throw $th;
                }
                $getTemporalCartProducts = Cart::Where('customer_id', $customerSessionID)->delete();
            }

            return $result = $api_response->getResult();
        } else {
            return $errors = $api_response->getErrors();
        }

    }

    public function index()
    {
        $products = Product::all()->take(3);
        return view('welcome', compact('products'));
    }
    public function cart()
    {

        $customerSessionID = Session::get('loggedin');
        $temporalShoppingID = Cookie::get('cus-shopping-id');

        if (isset($customerSessionID) || isset($temporalShoppingID)) {

            $getTemporalCartProducts = Cart::where('customer_id', $temporalShoppingID)->orWhere('customer_id', $customerSessionID)->get();

            if (!empty($getTemporalCartProducts)) {
                return view('cart');
            } else {
                return redirect('/');
            }
        }
        return redirect('/');

    }
    public function checkout()
    {

        $userdata = session('loggedin');
        if (!$userdata) {
            //$backurl = url()->previous();

            $backurl = url()->previous();
            session(['backurl' => $backurl]);

            return redirect()->route('authentication')->with('message', 'Authenticate first to checkout');

            // return    redirect(url('authentication'));

        }

        //     $customerSessionID = \Session::get('loggedin');
        //     $temporalShoppingID = Cookie::get('cus-shopping-id');
        //  return   Cart::where('customer_id', $temporalShoppingID)->orWhere('customer_id', $customerSessionID)->get();

        $days = array();
        $startdate = strtotime("Saturday");
        $enddate = strtotime("+6 weeks", $startdate);
        while ($startdate < $enddate) {
            $days[] = date("M d", $startdate);
            $startdate = strtotime("+1 week", $startdate);

        }

        $getTemporalCartProducts = Cart::Where('customer_id', $userdata)->get();

        $idvaleues = '';

        if ($getTemporalCartProducts->isNotEmpty()) {
            foreach ($getTemporalCartProducts as $key => $sItem) {
                if (empty($idvaleues)) {
                    $idvaleues = $idvaleues . $sItem->product_id . '-' . $sItem->quantity;
                } else {
                    $idvaleues = $idvaleues . ',' . $sItem->product_id . '-' . $sItem->quantity;
                }
            }
            return view('checkout', compact('days', 'idvaleues'));
        }
        return redirect('/');

    }
}
