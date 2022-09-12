<?php
namespace App\Traits;

class StringConverter{
    public function separateStringToArray($string){
        return explode("/", $string);
    }

    public function andConvertToLogicalAnd($string){
        return str_replace('wms-and','&',$string);
    }
}
