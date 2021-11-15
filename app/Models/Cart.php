<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //

    protected $appends = ['subprice', 'image', 'price', 'name', 'slug'];

    public function getSubpriceAttribute()
    {
        $image = null;
        $getId = $this->product_id;
        $quantity = $this->quantity;
        $total = 0;
        if ($getId) {

            $produdtFirstImage = Product::find($getId);
            if ($produdtFirstImage) {
                $price = $produdtFirstImage->price;
                $total = $quantity * $price;
            }
        }
        return $this->attributes['subprice'] = $total;
    }
    public function getImageAttribute()
    {
        $image = null;
        $getId = $this->product_id;
        if ($getId) {

            $produdtFirstImage = Product::find($getId);
            if ($produdtFirstImage) {
                $image = $produdtFirstImage->image;
            }
        }
        return $this->attributes['image'] = $image;
    }

    public function getPriceAttribute()
    {
        $price = null;
        $getId = $this->product_id;

        $getProduct = Product::find($getId);
        if ($getProduct) {
            $price = $getProduct->price;

        }
        return $this->attributes['price'] = $price;
    }

    public function getNameAttribute()
    {
        $productName = null;
        $getId = $this->product_id;

        $getProduct = Product::find($getId);
        if ($getProduct) {
            $productName = $getProduct->name;
        }
        return $this->attributes['name'] = $productName;
    }

    public function getSlugAttribute()
    {
        $slug = null;
        $getId = $this->product_id;

        $getProduct = Product::find($getId);
        if ($getProduct) {
            $slug = $getProduct->id;
        }
        return $this->attributes['slug'] = $slug;
    }
}
