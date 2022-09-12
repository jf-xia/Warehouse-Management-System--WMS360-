<?php

namespace App\Listeners;

use App\Events\WoocomQuantityUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pixelpeter\Woocommerce\Facades\Woocommerce;

class WoocomQuantityUpdateFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WoocomQuantityUpdate  $event
     * @return void
     */
    public function handle(WoocomQuantityUpdate $event)
    {

        foreach ($event->products as $product){
//            print_r($product['product_draft_id']);
//            echo '*';
//            print_r($product['variation_id']);
//            exit();
            $result = Woocommerce::get('products/'.$product['product_draft_id'].'/variations/'.$product['variation_id']);

//            var_dump($result);
//            exit();
            $variation_data = [
            'stock_quantity' => $result['stock_quantity']-$product['quantity'],
            ];
            $result = Woocommerce::put('products/'.$product['product_draft_id'].'/variations/'.$product['variation_id'],$variation_data);

        }


    }
}
