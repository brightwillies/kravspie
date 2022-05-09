<?php

namespace App\Http\Controllers;

use App\Customdate;
use App\Mail\AnorderMail;
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

    public function trymail()
    {

        $dataa = array();
        $mail = Mail::to('bwboakye@gmail.com')->send(new AnorderMail($dataa));

        return 'done';
    }
    public function categoryproducts($id)
    {
        $products = Product::where('category_id', $id)->where('status', 1)->get();
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
        $products = Product::where('id', '<>', $id)->get()->take(4);
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

        $type = $request->type;

        if ($type == 'guest') {

            $findCustomer = new Customer();
            $findCustomer->first_name = $request->first_name;
            $findCustomer->last_name = $request->last_name;
            $findCustomer->telephone_number = $request->telephone_number;
            $findCustomer->email = $request->email;
            $findCustomer->mask = generate_mask();
            $findCustomer->registered_on = gmdate('Y-m-d');
            $findCustomer->type = 'guest';
            $findCustomer->save();

            $tempid = Cookie::get('cus-shopping-id');

            $getTemporalCartProducts = Cart::Where('customer_id', $tempid)->get();

            if ($getTemporalCartProducts->isNotEmpty()) {
                foreach ($getTemporalCartProducts as $key => $sValue) {
                    $sValue->customer_id = $findCustomer->mask;
                    $sValue->save();
                }
            }
            $customerSessionID = $findCustomer->mask;

        } else {

            $customerSessionID = Session::get('loggedin');

            $findCustomer = Customer::where('mask', $customerSessionID)->first();

        }

        $itemsreceived = $request->items;
        $items = explode(',', $itemsreceived);

        $pickupdate = $request->pickupdate;
        $pickuptime = $request->pickuptime;

        $amount = $request->amount;
        // $client = new SquareClient([
        //     'accessToken' => 'EAAAEHysWwv1SNJvAja_QgpsBvmHDpg9PLgrX1Sztx1XRvELCpvMiI62ivo6JDHb',
        //     'environment' => Environment::SANDBOX,
        // ]);
        $client = new SquareClient([
            'accessToken' => 'EAAAFNoXBzoso8gSvI0LigwNpVF9veOak-n1x4wAUitcMWflkymJCWcLXlveKXao',
            'environment' => Environment::PRODUCTION,
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
            $newOrder->amount = ($amount / 100);
            $newOrder->placed_on = gmdate('Y-m-d H:i:s');
            $newOrder->mask = generate_random_password();
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
                    'cost' => ($amount / 100),
                    'pickupdate' => $pickupdate . ',' . now()->year,
                );

                try {
                    $dataa = array();
                    $mmail = Mail::to('joballard@kravspie.com')->send(new AnorderMail($dataa));
                    $mmaill = Mail::to('bwboakye@gmail.com')->send(new AnorderMail($dataa));
                    $mail = Mail::to($findCustomer->email)->send(new PurchaseConfirmation($data));
                } catch (\Throwable$th) {
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

        $products = Product::where('featured', 1)->get()->take(4);
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

        $type = "guest";

        $userdata = session('loggedin');
        $tempid = "";
        if (!$userdata) {

            // $backurl = url()->previous();
            // session(['backurl' => $backurl]);
            // return redirect()->route('authentication')->with('message', 'Authenticate first to checkout');

            $tempid = Cookie::get('cus-shopping-id');
            if (!$tempid) {
                return redirect()->route('home');
            }

        } else {
            $type = "customer";
        }

        $days = array();

        $getDates = Customdate::all();

        if ($getDates->isNotEmpty()) {
            foreach ($getDates as $key => $singDate) {

                $days[] = $singDate->month . " " . $singDate->number;
            }
        }

        $getTemporalCartProducts = Cart::Where('customer_id', $userdata)->orWhere('customer_id', $tempid)->get();

        $idvaleues = '';

        if ($getTemporalCartProducts->isNotEmpty()) {
            foreach ($getTemporalCartProducts as $key => $sItem) {
                if (empty($idvaleues)) {
                    $idvaleues = $idvaleues . $sItem->product_id . '-' . $sItem->quantity;
                } else {
                    $idvaleues = $idvaleues . ',' . $sItem->product_id . '-' . $sItem->quantity;
                }
            }

            // return $type;

            return view('checkout', compact('days', 'idvaleues', 'type'));
        }
        return redirect('/');
    }
}
