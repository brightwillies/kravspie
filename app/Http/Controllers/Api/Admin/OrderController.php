<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    use ResponseTrait; /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateOrder(Request $request, $id)
    {

        $getOrder = Order::where('mask', $id)->first();

        if ($getOrder) {
            $getOrder->status = $request->status;
            $getOrder->save();
        }
        return $this->successResponse('Order updated');
    }
    public function newOrders()
    {
        $records = Order::where('status', 0)->get();
        return $this->successResponse('', $records);
    }
    public function oldOrders()
    {
        $records = Order::where('status', 1)->get();
        return $this->successResponse('', $records);
    }
}
