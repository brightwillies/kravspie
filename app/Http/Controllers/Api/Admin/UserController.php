<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function customers()
    {

        $getRecords = Customer::orderBy('id', 'DESC')->get();
        return $this->successResponse('', $getRecords);
    }
    public function indexAdmin()
    {
        $getRecords = User::orderBy('id', 'DESC')->get();
        return $this->successResponse('', $getRecords);
    }

    public function storeAdmin(Request $request)
    {

        // try {
        $rules = [
            'email' => 'required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }

        $newRecord = new User();
        $newRecord->first_name = $request->first_name;
        $newRecord->last_name = $request->last_name;
        $newRecord->password = Hash::make($request->password);
        $newRecord->email = $request->email;
        $newRecord->telephone_number = $request->telephone_number;

        $newRecord->status = (int) $request->status ?: ST_ACTIVE;
        $newRecord->mask = generate_mask();
        if ($newRecord->save()) {

            return $this->successResponse(SUCCESS_CREATING_MESSAGE);
        }
        return $this->errorResponse('Failed to process your request');
        // } catch (Exception $e) {

        //     return $this->errorResponse($e);
        // }
    }

}
