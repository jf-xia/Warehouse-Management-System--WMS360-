<?php


namespace App\Http\Controllers\CheckQuantity;


use App\Http\Controllers\Channel\ChannelFactory;
use App\Http\Controllers\Channel\Onbuy;
use App\Http\Controllers\Channel\Woocommerce;
use App\Http\Controllers\Channel\Ebay;
use App\Http\Controllers\Channel\WMS;
use App\ProductOrder;
use App\ProductVariation;
use App\ShelfedProduct;
use App\Client;
use App\Shelf;
use App\ReshelvedProduct;

class CheckQuantity
{
    public function checkQuantity($sku,$quantity=null,$avialable_quantity = null, $change_reason = null,$ordered_quantity = null,$force_update=false,$account_id = null){

        $variation_product = ProductVariation::where('sku',$sku)->get()->first();
        if ($quantity == null && $avialable_quantity == null){
            $updated_available_quantity = $this->getUpdateAvailableQuantity($variation_product->id);
        }elseif ($quantity != null && $avialable_quantity == null){
            $updated_available_quantity = $this->getUpdateAvailableQuantity($variation_product->id);
            $updated_available_quantity = $updated_available_quantity + $quantity;
        }elseif($avialable_quantity != null && $quantity == null){
            $shelfUse = Client::first()->shelf_use ?? 0;
            if($shelfUse == 0){
                $variation_id = $variation_product->id;
                $updated_available_quantity = $avialable_quantity + $this->getPendingOrderQuantity($variation_id);
                $singleProductShelfQuantity = ShelfedProduct::where('variation_id',$variation_id)->sum('quantity');
                if($singleProductShelfQuantity > $updated_available_quantity){
                    $quantityDiff = $singleProductShelfQuantity - $updated_available_quantity;
                    $singleProductShelfInfo = ShelfedProduct::where('variation_id',$variation_id)->get();
                    if(count($singleProductShelfInfo) > 0){
                        foreach($singleProductShelfInfo as $shelfInfo){
                            if($quantityDiff >= $shelfInfo->quantity){
                                $quantityDecrementInfo = ShelfedProduct::find($shelfInfo->id)->decrement('quantity',$shelfInfo->quantity);
                                $quantityDiff -= $shelfInfo->quantity;
                            }else{
                                $quantityDecrementInfo = ShelfedProduct::find($shelfInfo->id)->decrement('quantity',$quantityDiff);
                                break;
                            }
                        }
                    }
                }else{
                    $shelfInfo = Shelf::first();
                    if($shelfInfo){
                        $productShelfInfo = ShelfedProduct::where('variation_id',$variation_id)->first();
                        $quantityDiff = $updated_available_quantity - $singleProductShelfQuantity;
                        if($productShelfInfo){
                            $shelfQuantityUpdate = ShelfedProduct::find($productShelfInfo->id)->increment('quantity',$quantityDiff);
                        }else{
                            $insertShelfInfo = new ShelfedProduct();
                            $insertShelfInfo->shelf_id = $shelfInfo->id;
                            $insertShelfInfo->variation_id = $variation_id;
                            $insertShelfInfo->quantity = $quantityDiff;
                            $insertShelfInfo->created_at = now();
                            $insertShelfInfo->updated_at = now();
                            $insertShelfInfo->save();
                        }
                    }
                }
                $updated_available_quantity = $avialable_quantity;
            }else{
                $updated_available_quantity = $avialable_quantity;
            }
        }

        $get_channel = new ChannelFactory();
        $channels = $get_channel->getChannelArray();
        foreach($channels as $channel){
            $channel->updateQuantity($sku,$updated_available_quantity,$change_reason,null,$ordered_quantity,$force_update,$account_id);
        }
    }

    public function getUpdateAvailableQuantity($variation_id){
        $shelf_quantity = ShelfedProduct::where('variation_id',$variation_id)->sum('quantity');
        $pending_order_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('quantity');
        $pending_order_picked_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('picked_quantity');
        $pending_order_available_quantity = $pending_order_quantity-$pending_order_picked_quantity;

        $updated_available_quantity = ($this->exitsReshelveProduct($variation_id) + $shelf_quantity) - $pending_order_available_quantity;
        return $updated_available_quantity;
    }

    public function getShelfQuantity($variation_id)
    {
        $product_variation = ProductVariation::where('id', $variation_id)->get()->first();
        return $product_variation->actual_quantity;
    }

    public function getPendingOrderQuantity($variation_id){
        $pending_order_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('quantity');
        $pending_order_picked_quantity = ProductOrder::where('variation_id',$variation_id)->where('status', 0)->sum('picked_quantity');
        $pending_order_available_quantity = $pending_order_quantity-$pending_order_picked_quantity;
        return $pending_order_available_quantity;
    }

    public function exitsReshelveProduct($variation_id){
        $totalReshelveProduct = ReshelvedProduct::where('variation_id',$variation_id)->where('status',0)->sum('quantity');
        $totalShelvedProduct = ReshelvedProduct::where('variation_id',$variation_id)->where('status',0)->sum('shelved_quantity');
        return $totalReshelveProduct - $totalShelvedProduct;
    }


}
