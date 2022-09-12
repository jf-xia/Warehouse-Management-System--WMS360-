<?php


namespace App\Http\Controllers;


use App\ProductOrder;
use App\ShelfedProduct;

class CheckEbayQuantity
{
    public function checkQuantity($channel,$product,$quantity){

        $quantity = $quantity;
        $updated_available_quantity = $this->getUpdateAvailableQuantity($product->master_variation_id);


    }

    public function getUpdateAvailableQuantity($variation_id){
        $shelf_quantity = ShelfedProduct::where('variation_id',$variation_id)->sum('quantity');
        $pending_order_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('quantity');
        $pending_order_picked_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('picked_quantity');
        $pending_order_available_quantity = $pending_order_quantity-$pending_order_picked_quantity;

        $updated_available_quantity = $shelf_quantity - $pending_order_available_quantity;
        return $updated_available_quantity;
        $ebay = new UpdateEbayQuantity();
        $updateQuantity = new UpdateQuantity();

        $updateQuantity->update($ebay,$order['TransactionArray']['Transaction']['Variation']['SKU'],$update_quantity);

    }
}
