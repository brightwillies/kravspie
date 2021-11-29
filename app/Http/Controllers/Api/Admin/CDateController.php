<?php

namespace App\Http\Controllers\Api\Admin;

use App\Customdate;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CDateController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Customdate::all();

        return $this->successResponse('', $records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                "number" => "required",
                "month" => "required",

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $newRecord = new Customdate();
            $newRecord->number = $request->number;
            $newRecord->month = $request->month;
            $newRecord->mask = generate_mask();
            if ($newRecord->save()) {

                return $this->successResponse(SUCCESS_CREATING_MESSAGE);
            }
        } catch (Exception $e) {

            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $findRecord = Customdate::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }

        try {
            $rules = [
                "name" => "required",

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            $findRecord->number = $request->number;
            $findRecord->month = $request->month;
            if ($findRecord->save()) {

                return $this->successResponse(SUCCESS_UPDATING_MESSAGE);
            } else {
                return $this->errorResponse('There was an error in processing your request');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findRecord = Customdate::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }

        $findRecord = Customdate::where('mask', $id)->delete();

        return $this->successResponse(SUCCESS_DELETING_MESSAGE);
    }
}
