<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

if (!function_exists("generate_mask")) {
    function generate_mask()
    {
        return $uuid = (string) Str::orderedUuid();
    }
}
if (!function_exists("generate_random_password")) {
    function generate_random_password($min = 1111, $max = 9999999)
    {
        return rand($min, $max);
    }
}

if (!function_exists("deleteItemOldImage")) {
    function deleteOldImage($filename, $folder)
    {
        $path = "/" . $folder . "/" . $filename;
        File::delete(($path));
    }
}

if (!function_exists("uploadItemImage")) {
    function uploadItemImage($file, $name, $folder, $subfix = null)
    {
        $extension = $file->getClientOriginalExtension();
        $originalName = Str::slug($name) . $subfix;
        $imageName = $originalName . '.' . $extension;
        $file->move(($folder), $imageName);
        // Storage::disk('uploads')->put($imageName,$file);
        $url = url('/');
        $path = $url . '/' . $folder . '/' . $imageName;
        $result = new \stdClass();
        $result->filename = $imageName;
        $result->path = $path;
        return $result;
    }
}

if (!function_exists("generate_mask_string")) {
    function generate_mask_string($min = 1111, $max = 9999999)
    {
        return md5(uniqid(mt_rand($min, $max)));
    }
}


