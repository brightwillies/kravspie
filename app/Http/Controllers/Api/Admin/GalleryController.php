<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{

    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Gallery::all();

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
        //  return $request;

        // try {
        $rules = [
            'title' => 'required',
            'images' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }

        $deleteErrorImages = array();
        $loggedInUser = auth()->user();
        $createdBy = $loggedInUser->id;

        $newRecord = new Gallery();
        $newRecord->title = $request->title;
        $newRecord->date = $request->date;
        $newRecord->created_by = $createdBy;
        $newRecord->status = (int) $request->status ?: ST_ACTIVE;
        $newRecord->mask = generate_mask();

        if ($newRecord->save()) {
            if (isset($request->images)) {

                if (count($request->images)) {
                    foreach ($request->images as $key => $image) {

                        $uploadResult = uploadItemImage($image, $request->title . $key, ST_GALLERY);
                        if ($uploadResult) {

                            $newProductImage = new GalleryImage();
                            $newProductImage->gallery_id = $newRecord->id;
                            $newProductImage->image = $uploadResult->path;
                            $newProductImage->image_filename = $uploadResult->filename;
                            $newProductImage->save();
                            $deleteErrorImages[] = array('filename' => $uploadResult->filename);
                        }
                    }
                }
            }
            return $this->successResponse(SUCCESS_CREATING_MESSAGE);

        }
        return $this->errorResponse('Failed to process your request');
        // } catch (Exception $e) {
        //     foreach ($deleteErrorImages as $key => $value) {
        //         $value = (object) $value;
        //         deleteOldImage($value->filename, ST_GALLERY);
        //     }
        //     return $this->errorResponse($e);
        // }
    }
    public function update(Request $request, $id)
    {

        $deleteErrorImages = array();
        $newRecord = Gallery::where('mask', $id)->first();
        if (!$newRecord) {
            return $this->errorResponse('Resource not found');
        }

        try {
            $rules = [
                'title' => 'required',
                'status' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return $this->validationResponse($errors);
            }
            $newRecord->title = $request->title;

            $newRecord->status = (int) $request->status;
            if ($newRecord->save()) {
                if (isset($request->images)) {

                    if (count($request->images)) {
                        foreach ($request->images as $key => $image) {

                            $uploadResult = uploadItemImage($image, $request->title . $key, ST_GALLERY);
                            if ($uploadResult) {
                                $newProductImage = new GalleryImage();
                                $newProductImage->gallery_id = $newRecord->id;
                                $newProductImage->image = $uploadResult->path;
                                $newProductImage->image_filename = $uploadResult->filename;
                                $newProductImage->save();
                                $deleteErrorImages[] = array('filename' => $uploadResult->filename);
                            }
                        }
                    }
                }
                return $this->successResponse(SUCCESS_UPDATING_MESSAGE);
            }
            return $this->errorResponse('Failed to process your request');
        } catch (Exception $e) {
            foreach ($deleteErrorImages as $key => $value) {
                $value = (object) $value;
                deleteOldImage($value->filename, ST_GALLERY);
            }
            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $findRecord = Gallery::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }
        return $this->successResponse('', $findRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $findRecord = Gallery::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }

        $findRecord->delete();
        $items = GalleryImage::where('gallery_id', $findRecord->id)->get();
        if ($items->isNotEmpty()) {
            foreach ($items as $key => $value) {
                deleteOldImage($value->image_filename, ST_GALLERY);
            }
        }
        GalleryImage::where('gallery_id', $findRecord->id)->delete();

        return $this->successResponse(SUCCESS_DELETING_MESSAGE);

    }

    public function destroyImage($id)
    {

        $productImage = GalleryImage::where('id', $id)->first();
        if (!$productImage) {
            return $this->errorResponse('Resource not found');
        }

        deleteOldImage($productImage->image_filename, ST_GALLERY);
        $productImage->delete();
        return $this->successResponse(SUCCESS_IMAGE_DELETING_MESSAGE);

        return $this->errorResponse(ERROR_DELETING_MESSAGE);
    }

}
