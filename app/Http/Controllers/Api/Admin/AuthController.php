<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordChange;
use App\Models\RolePermission;
use App\Models\User;
use App\Traits\ResponseTrait;
use DateTime;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    use ResponseTrait;

    public function store(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email',
                'role_id' => 'required',
                'telephone_number' => 'required',
                'password' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $newRecord = new User();
            $newRecord->first_name = $request->first_name;
            $newRecord->last_name = $request->last_name;
            $newRecord->email = $request->email;
            $newRecord->telephone_number = $request->telephone_number;
            $newRecord->role_id = 1;
            $newRecord->password = Hash::make($request->password);
            $newRecord->status = ST_ACTIVE;
            $newRecord->mask = generate_mask();
            if ($newRecord->save()) {
                return $this->successResponse('Admin account created successfully');
            }
            return $this->errorResponse('Failed to process your request');
        } catch (Exception $e) {

            return $this->errorResponse($e);
        }

    }
    public function index()
    {

        $records = User::all();
        return $this->successResponse('', $records);
    }
    public function updatepassword(Request $request, $id)
    {
        $newRecord = User::where('mask', $id)->first();
        if (!$newRecord) {
            return $this->errorResponse('Record does not exist');
        }

        try {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();

                return $this->validationResponse($errors);
            }
            if (Hash::check($request->current_password, $newRecord->password)) {
                $newRecord->password = Hash::make($request->new_password);
                if ($newRecord->save()) {

                    Mail::to($newRecord->email)->send(new PasswordChange([
                        "name" => "{$newRecord->first_name}",
                        "password" => $request->new_password,
                    ]));
                    return $this->successResponse("Password updated successfully, kindly logout and login");
                }
                return $this->errorResponse('There was an error in processing your request');
            }
            return $this->errorResponse('Your current password is incorrect, try again');
        } catch (Exception $e) {

            return $this->errorResponse($e);
        }
    }

    public function login(Request $request)
    {

        try {
            $rules = [

                'email' => 'required',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $password = $request->password;
            $email = $request->email;
            $admin = User::where('email', (string) $email)->first();
            if (!$admin) {
                return $this->wrongCredentialsResponse();
                //  return $this->errorResponse('You have entered an invalid email or password');
            }

            if ($admin->status != 1) {
                return $this->wrongCredentialsResponse('You account has been deactivated');

            }
            if (Hash::check($password, $admin->password)) {

                // $roleId = $admin->role_id;
                // $userpemissions = array();

                // $getPermission = RolePermission::where('role_id', $roleId)->get();
                // if (!empty($getPermission)) {
                //     foreach ($getPermission as $key => $pem) {

                //         $userpemissions[] = $pem->permission;
                //     }
                // }

                $payload = [
                    "iss" => url("/"),
                    "iat" => time(),
                    "id" => $admin->id,
                ];
                // Generate token
                if ($token = JWT::encode($payload, config("app.key"))) {

                    $admin->last_login = new DateTime();
                    $admin->save();
                    return $this->successResponse("Login Successful", [
                        "user" => $admin,
                        "token" => $token,
                        // 'permissions' => $userpemissions,
                    ]);
                }
            }return $this->wrongCredentialsResponse();
            return $this->errorResponse('You have entered an invalid email or password');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function updateProfile(Request $request, $id)
    {

        $getUser = User::where('mask', $id)->first();
        if (!$getUser) {
            return $this->errorResponse('', 'Admin record cannot be found');
        }
        $getUser->first_name = $request->first_name;
        $getUser->last_name = $request->last_name;
        $getUser->telephone_number = $request->telephone_number;
        $getUser->status = (int) $request->status;
        $getUser->email = $request->email;
        if ($getUser->save()) {
            return $this->successResponse('Profile updated successfully', $getUser);
        }
    }

}
