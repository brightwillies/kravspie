<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $appends = ['status_name', 'category'];

    public function getcategoryAttribute()
    {
        $category = '';
        $getStatus = $this->category_id;

        $getRecord = Category::find($getStatus);

        if ($getRecord) {
            $category = $getRecord->name;
        }
        return $this->attributes['category'] = $category;
    }

    public function getStatusNameAttribute()
    {
        $statusName = '';
        $getStatus = $this->status;
        if ($getStatus == 0) {
            $statusName = 'Inactive';
        } elseif ($getStatus == 1) {
            $statusName = 'Active';
        }
        return $this->attributes['status_name'] = $statusName;
    }

}
