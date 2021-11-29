<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function statistics()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 0)->count();
        $completedOrders = Order::where('status', 1)->count();

        $data = array(
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
        );
        return $this->successResponse('', $data);

    }
    public function index()
    {
        //

        $records = Product::all();
        return $this->successResponse('', $records)
        ;}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'status' => 'required',
            // 'category_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }
        $newRecord = new Product();
        $newRecord->name = $request->name;
        $newRecord->status = (int) $request->status;
        $newRecord->featured = (int) $request->featured;
        $newRecord->price = $request->price;
        // $newRecord->category_id = $request->category_id;
        $newRecord->description = $request->description;
        $newRecord->mask = generate_mask();
        $webImage = $request->file('featured_image');
        if ($webImage) {
            $uploadResult = uploadItemImage($webImage, $request->name, ST_PRODUCTS);
            if ($uploadResult) {
                $newRecord->image = $uploadResult->path;
                $newRecord->image_filename = $uploadResult->filename;
            }
        }

        if ($newRecord->save()) {

            return $this->successResponse('Product saved successfully');
        }
        return $this->errorResponse('Product was not able to be saved');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $newRecord = Product::where('mask', $id)->first();
        return $this->successResponse('', $newRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $newRecord = Product::where('mask', $id)->first();
        $newRecord->name = $request->name;
        $newRecord->status = (int) $request->status;
        $newRecord->featured = (int) $request->featured;
        $newRecord->price = $request->price;
        $newRecord->description = $request->description;
        // $newRecord->category_id = $request->category_id;

        $webImage = $request->file('featured_image');
        if ($webImage) {
            $uploadResult = uploadItemImage($webImage, $request->name, ST_PRODUCTS);
            if ($uploadResult) {
                $newRecord->image = $uploadResult->path;
                $newRecord->image_filename = $uploadResult->filename;
            }
        }
        $newRecord->save();
        return $this->successResponse('Product Updated Successfully', $newRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
