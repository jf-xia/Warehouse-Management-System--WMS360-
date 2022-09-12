<?php


namespace App\Http\Controllers\Channel;


interface EChannel
{
    public function updateQuantity($sku,$quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false);
    public function getChannelName();
}
