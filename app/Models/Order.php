<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $appends = ['items','status_name', 'customer', 'telephone'];

    public function getItemsAttribute()
    {
       
        $getId = $this->id;

        $items = OrderItem::where('order_id', $getId)->get();


        return $this->attributes['items'] =  $items;
    }
    public function getCustomerAttribute()
    {
        $custommer = '';
        $getId = $this->customer_id;

        $findCustomer = Customer::where('mask', $getId)->first();

        if($findCustomer){
            $custommer= $findCustomer->first_name . ' '. $findCustomer->last_name;
        }
        return $this->attributes['customer'] = $custommer;
    }
    public function getTelephoneAttribute()
    {
        $telephone = '';
        $getId = $this->customer_id;

        $findCustomer = Customer::where('mask', $getId)->first();

        if($findCustomer){
            $telephone = $findCustomer->telephone_number;
        }
        return $this->attributes['telephone'] = $telephone;
    }
    public function getStatusNameAttribute()
    {
        $statusName = '';
        $getStatus = $this->status;
        if ($getStatus == 0) {
            $statusName = 'Pending';
        } elseif ($getStatus == 1) {
            $statusName = 'Completed';
        }
        return $this->attributes['status_name'] = $statusName;
    }
}
