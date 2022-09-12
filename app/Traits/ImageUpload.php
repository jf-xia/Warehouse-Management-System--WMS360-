<?php
namespace App\Traits;

use Carbon\Carbon;

trait ImageUpload{
    public function base64ToImage($catalogueId ,$imageName, $uplaodImage, $imagePath){
        $image_64 = $uplaodImage; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64); 
        $image = str_replace(' ', '+', $image); 
        $updateName = $catalogueId.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
        $updateName .= '-'.str_replace(' ', '-',$imageName);
        //$folderPath = "uploads/product-images/";
        $folderPath = $imagePath;
        $image_base64 = base64_decode($image);
        $file = $folderPath . $updateName;
        file_put_contents($file, $image_base64);
        return $updateName;
    }

    public function singleBase64ToImage($uploadImageName, $uplaodImageBase64value, $imagePath){
        $image_64 = $uplaodImageBase64value; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64); 
        $image = str_replace(' ', '+', $image); 
        $updateName = rand(10000, 99999).'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
        $updateName .= '-'.str_replace(' ', '-',$uploadImageName);
        //$folderPath = "uploads/product-images/";
        $folderPath = $imagePath;
        $image_base64 = base64_decode($image);
        $file = $folderPath . $updateName;
        file_put_contents($file, $image_base64);
        return $updateName;
    }


}