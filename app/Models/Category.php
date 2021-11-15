<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $appends = ['total','status_name'];


    public function getTotalAttribute()
    {
        $statusName = '';
        $getID = $this->id;
        
        $count = @Product::where('category_id', $getID)->count();
        return $this->attributes['total'] = $count;
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
