<?php


namespace App\Http\Controllers\Channel;


use App\Client;
use App\ProductVariation;
use App\Shelf;
use App\ShelfedProduct;
use App\Traits\ActivityLogs;
use Illuminate\Support\Facades\Session;

class WMS implements EChannel
{
    public function getChannelName(){
        return "wms";
    }
    public function updateQuantity($sku, $quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false)
    {
        $product_variation_result = ProductVariation::where('sku' ,$sku)->get()->first();
        if ($product_variation_result != null) {
            // $shelfUse = Session::get('shelf_use');
            // if ($shelfUse == '') {
            //     $shelfUse = Client::first()->shelf_use ?? null;
            // }
            // if ($shelfUse == 0) {
            //     $shelfId = Shelf::first()->id;
            //     if ($shelfId) {
            //         $productShelfInfo = ShelfedProduct::where('shelf_id', $shelfId)
            //             ->where('variation_id', $product_variation_result->id)
            //             ->where('quantity', '>', 0)->first();
            //         if ($productShelfInfo) {
            //             $updateInfo = ShelfedProduct::find($productShelfInfo->id)->update([
            //                 'quantity' => $quantity
            //             ]);
            //         }
            //     }
            // }
            ProductVariation::where('sku',$sku)->update(['actual_quantity' => $quantity]);
        }
    }

}
