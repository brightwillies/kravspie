<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Category::orderBy('created_at', 'DESC')->get();

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
                "name" => "required|unique:categories,name",
               
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }

            // Process data
            DB::beginTransaction();
            $newRecord = new Category();
            $newRecord->name = $request->name;
            $newRecord->mask = generate_mask();
            $newRecord->status = $request->status ?: ST_ACTIVE;
            $newRecord->description = $request->description;
            if ($newRecord->save()) {


                DB::commit();
                return $this->successResponse(SUCCESS_CREATING_MESSAGE);
            }
        } catch (Exception $e) {
            DB::rollBack();
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

        $findRecord = Category::where('mask', $id)->first();
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


            $findRecord->name = $request->name;
            $findRecord->status = (int) $request->status ?: ST_ACTIVE;
            $findRecord->description = $request->description;
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
        $findRecord =Category::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }

     
        $findRecord =Category::where('mask', $id)->delete();

        return $this->successResponse(SUCCESS_DELETING_MESSAGE);
    }
}
