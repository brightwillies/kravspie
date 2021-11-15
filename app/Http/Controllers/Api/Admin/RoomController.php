<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feature;
use App\Models\Room;
use App\Models\RoomFeature;
use App\Models\RoomPicture;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    use ResponseTrait;

    public function getTotal()
    {
        $todayCount = Booking::whereDate('arrival_date', Carbon::today())->count();
        $todayPaid = Booking::whereDate('arrival_date', Carbon::today())->whereNotNull('payment_reference')->whereNotNull('amount_paid')->count();
        $todaUnpaid = Booking::whereDate('arrival_date', Carbon::today())->whereNull('payment_reference')->whereNull('amount_paid')->count();

        $data = array(
            'todayCount' => $todayCount,
            'todayPaid' => $todayPaid,
            'todayUnpaid' => $todaUnpaid,
        );
        return $this->successResponse('', $data);
    }
    public function destroyImage($id)
    {

        $productImage = RoomPicture::where('id', $id)->first();
        if (!$productImage) {
            return $this->errorResponse('Resource not found');
        }

        deleteOldImage($productImage->image_filename, ST_ROOMS_FOLDER);
        $productImage->delete();
        return $this->successResponse(SUCCESS_IMAGE_DELETING_MESSAGE);

        return $this->errorResponse(ERROR_DELETING_MESSAGE);
    }

    public function index()
    {

        $records = Room::all();
        return $this->successResponse('', $records);
    }
    public function show($id)
    {
        $record = Room::where('mask', $id)->first();
        return $this->successResponse('', $record);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //try {
        $rules = [
            'name' => 'required|unique:rooms,name',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }

        $loggedInUser = auth()->user();
        $createdBy = $loggedInUser->id;

        $newRecord = new Room();
        $newRecord->name = $request->name;
        $newRecord->price_per_night = $request->price_per_night;
        $newRecord->number_of_people = $request->number_of_people;
        $newRecord->description = $request->description;
        $newRecord->mask = Str::slug($request->name);
        $newRecord->status = (int) $request->status ?: ST_ACTIVE;
        $newRecord->created_by = $createdBy;
        $webImage = $request->file('featured_image');

        if ($webImage) {

            $uploadResult = uploadItemImage($webImage, $request->name, ST_ROOMS_FOLDER);
            if ($uploadResult) {
                $newRecord->image = $uploadResult->path;
                $newRecord->image_filename = $uploadResult->filename;
            }
        }
        if ($newRecord->save()) {

            if (!empty($request->images)) {
                foreach ($request->images as $key => $image) {
                    $uploadResult = uploadItemImage($image, $request->name . '-' . ($key + 1), ST_ROOMS_FOLDER);
                    if ($uploadResult) {
                        $newProductImage = new RoomPicture();
                        $newProductImage->room_id = $newRecord->id;
                        $newProductImage->image = $uploadResult->path;
                        $newProductImage->image_filename = $uploadResult->filename;
                        $newProductImage->save();
                        $deleteErrorImages[] = array('folder' => ST_PRODUCTS_FOLDER, 'filename' => $uploadResult->filename);
                    }
                }
            }

            $featuedArray = explode(',', $request->features);
            foreach ($featuedArray as $key => $value) {

                $newRoomFeature = new RoomFeature();
                $newRoomFeature->room_id = $newRecord->id;
                $newRoomFeature->feature_id = $value;
                $newRoomFeature->save();
            }

            return $this->successResponse(SUCCESS_CREATING_MESSAGE);
        }
        return $this->errorResponse(ERROR_CREATING_MESSAGE);
        // } catch (Exception $e) {

        //     return $this->errorResponse($e);
        // }
    }

    public function update(Request $request, $id)
    {
        // try {

        $findRecord = Room::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }
        $findRecord->name = $request->name;
        $findRecord->price_per_night = $request->price_per_night;
        $findRecord->number_of_people = $request->number_of_people;
        $findRecord->description = $request->description;
        $findRecord->status = (int) $request->status ?: ST_ACTIVE;
        $webImage = $request->file('featured_image');
        if ($webImage) {

            $uploadResult = uploadItemImage($webImage, $request->name, ST_ROOMS_FOLDER);
            if ($uploadResult) {
                $findRecord->image = $uploadResult->path;
                $findRecord->image_filename = $uploadResult->filename;
            }
        }

        if ($findRecord->save()) {

            // RoomPicture::where('room_id', $findRecord->id)->delete();
            RoomFeature::where('room_id', $findRecord->id)->delete();
            if ($request->images) {
                foreach ($request->images as $key => $image) {
                    $uploadResult = uploadItemImage($image, $request->name . '-' . ($key + 1), ST_ROOMS_FOLDER);
                    if ($uploadResult) {
                        $newProductImage = new RoomPicture();
                        $newProductImage->room_id = $findRecord->id;
                        $newProductImage->image = $uploadResult->path;
                        $newProductImage->image_filename = $uploadResult->filename;
                        $newProductImage->save();
                        $deleteErrorImages[] = array('folder' => ST_ROOMS_FOLDER, 'filename' => $uploadResult->filename);
                    }
                }
            }

            $featuedArray = explode(',', $request->features);
            foreach ($featuedArray as $key => $value) {

                $newRoomFeature = new RoomFeature();
                $newRoomFeature->room_id = $findRecord->id;
                $newRoomFeature->feature_id = $value;
                $newRoomFeature->save();
            }

            return $this->successResponse(SUCCESS_UPDATING_MESSAGE);
        } else {
            return $this->errorResponse('Resource not found');
        }
        // } catch (Exception $e) {
        //     return $this->errorResponse($e);
        // }
    }

    public function destroy($id)
    {
        $findRecord = Room::where('mask', $id)->first();
        if (!$findRecord) {
            return $this->errorResponse('Resource not found');
        }
        $findRecord->delete();
        return $this->successResponse(SUCCESS_DELETING_MESSAGE);

    }

    public function indexFeature()
    {

        $records = Feature::all();
        return $this->successResponse('', $records);
    }
    public function storeFeature(Request $request)
    {

        $rules = [
            'feature' => 'required|unique:features,feature',
            // 'content' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return $this->validationResponse($errors);
        }

        $newRecord = new Feature();
        $newRecord->feature = $request->feature;
        $newRecord->save();
        return 'Done';
    }

}
