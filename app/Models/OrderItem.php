<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        $name = '';
        $getId = $this->product_id;

        $findItem = Product::find($getId);

        if ($findItem) {
            $name = $findItem->name;
        }
        return $this->attributes['name'] = $name;
    }
}
