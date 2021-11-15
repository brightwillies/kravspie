<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Mail\RegistrationEmail;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function forgetpass()
    {

        return view('forgetpassword');
    }

    public function forgotPassword(Request $request)
    {
        if (!$request->email) {

            return Redirect::back()->withErrors(['message' => 'Please enter your email']);
        }
        $user = Customer::where("email", $request->email)->first();
        if ($user) {
            DB::beginTransaction();

            $password = generate_random_password();

            $user->password = Hash::make($password);
            if ($user->save()) {

                Mail::to($user->email)->send(new PasswordReset([
                    "name" => "{$user->first_name}",
                    "password" => $password,
                ]));
                $exploded = explode("@", $user->email);
                $maskedEmail = $exploded[0];
                $maskedEmail = substr($maskedEmail, -3);
                $maskedEmail = "xxxxxxxxxx{$maskedEmail}@{$exploded[1]}";
                $message = "Your new password has been sent to {$maskedEmail}";
                DB::commit();
                return redirect()->back()->with('message', $message);

            }
        }
    }
    public function login(Request $request)
    {

        if (!$request->password) {

            return Redirect::back()->withErrors(['message' => 'Please enter password']);
        }

        if (!$request->email) {

            return Redirect::back()->withErrors(['message' => 'Please enter your email']);
        }

        $password = $request->password;
        $email = $request->email;
        $admin = Customer::where('email', (string) $email)->first();
        if (!$admin) {
            return Redirect::back()->withErrors(['message' => 'wrong credentials']);
            //  return $this->errorResponse('You have entered an invalid email or password');
        }

        if (Hash::check($password, $admin->password)) {

            session(['loggedin' => $admin->mask]);

            $customerSessionID = Session::get('loggedin');
            $tempid = Cookie::get('cus-shopping-id');

            if (!empty($customerSessionID)) {

                $getTemporalCartProducts = Cart::Where('customer_id', $customerSessionID)->orWhere('customer_id', $tempid)->get();

                if ($getTemporalCartProducts->isNotEmpty()) {
                    foreach ($getTemporalCartProducts as $key => $sValue) {
                        $sValue->customer_id = $admin->mask;
                        $sValue->save();
                    }
                }
            }
            if ($backurl = session('backurl')) {

                session()->forget(['backurl']);

                return redirect('/checkout');
            } else {
                return redirect('/');
            }

        }
        return Redirect::back()->withErrors(['message' => 'wrong credentials']);

    }
    public function register(Request $request)
    {

        if ($request->password != $request->confirm_password) {

            return Redirect::back()->withErrors(['message' => 'Passwords are not the same']);
        }
        $newRecord = new Customer();
        $newRecord->first_name = $request->first_name;
        $newRecord->last_name = $request->last_name;
        $newRecord->telephone_number = $request->telephone_number;
        $newRecord->email = $request->email;
        $newRecord->password = Hash::make($request->password);
        $newRecord->mask = generate_mask();
        $newRecord->registered_on = gmdate('Y-m-d');
        $newRecord->save();

        $data = array(
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email);
        // try {

        $mail = Mail::to($request->email)->send(new RegistrationEmail($data));

        // } catch (\Throwable $th) {
        //     throw $th;
        // }
        session(['loggedin' => $newRecord->mask]);

        $customerSessionID = Session::get('loggedin');

        if (!empty($customerSessionID)) {

            $getTemporalCartProducts = Cart::Where('customer_id', $customerSessionID)->get();

            if ($getTemporalCartProducts->isNotEmpty()) {
                foreach ($getTemporalCartProducts as $key => $sValue) {
                    $sValue->customer_id = $newRecord->mask;
                    $sValue->save();
                }
            }
        }
        if ($backurl = session('backurl')) {

            session()->forget(['backurl']);

            return redirect('/checkout');
        } else {
            return redirect('/');
        }
        // return
    }

}
