

            <div style="border: 1px solid #ccc;">
                <div class="row m-t-10">
                    <div class="col-2 text-center">
                        <h6> Image </h6>
                        <hr class="order-hr" width="60%">
                    </div>
                    <div class="col-3 text-center">
                        <h6> Name </h6>
                        <hr class="order-hr" width="90%">
                    </div>
                    <div class="col-2 text-center">
                        <h6>SKU</h6>
                        <hr class="order-hr" width="60%">
                    </div>
                    <div class="col-2 text-center">
                        <h6>Shelf</h6>
                        <hr class="order-hr" width="60%">
                    </div>
                    <div class="col-1 text-center">
                        <h6> Quantity </h6>
                        <hr class="order-hr" width="60%">
                    </div>
                    <div class="col-2 text-center">
                        <h6> Price </h6>
                        <hr class="order-hr" width="60%">
                    </div>
                </div>
                @foreach($product_info->productOrders as $product)
                    <div class="row pt-2">
                        <div class="col-2 text-center">
                            @if(isset($product->image))
                                <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                            @else
                                <a href="{{$product->product_draft->single_image_info->image_url}}">
                                    <img src="{{$product->product_draft->single_image_info->image_url}}" width="50px" height="50px">
                                </a>
                            @endif
                        </div>
                        <div class="col-3 text-center">
                            <h7> {{$product->pivot->name}} </h7>
                        </div>
                        <div class="col-2 text-center">
                            <h7>
                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}} </span>
                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                            </h7>
                        </div>
                        <div class="col-2 text-center">
                            @foreach($product->shelf_quantity as $shelf)
                                <h7> {{$shelf->shelf_name}} -> {{$shelf->pivot->quantity}} </h7>
                            @endforeach
                        </div>
                        <div class="col-1 text-center">
                            <h7> {{$product->pivot->quantity}} </h7>
                        </div>
                        <div class="col-2 text-center">
                            <h7> {{$product->pivot->price}} </h7>
                        </div>
                    </div>
                @endforeach
                <div class="row m-b-20 m-t-10">
                    <div class="col-8 text-center"></div>
                    <div class="col-2 text-center">
                        <h7 class="font-weight-bold"> Total</h7>
                    </div>
                    <div class="col-2 text-center">
                        <h7 class="font-weight-bold"> {{$product_info->total_price}}</h7>
                    </div>
                </div>
            </div>



            <!--- Shipping Billing --->
            <div style="border: 1px solid #ccc" class="m-t-20">
                <div class="shipping-billing">
                    <div class="shipping">
                        <div class="d-block mb-5">
                            <h6>Shipping</h6>
                            <hr class="m-t-5 float-left" width="50%">
                        </div>
                        <div class="shipping-content">
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Name </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_user_name}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Phone </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_phone}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Address Line 1 </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_address_line_1}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Address Line 2 </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_address_line_2}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Address Line 3 </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_address_line_3}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> City </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_city}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> County </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_county}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Post code </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_post_code}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-2">
                                <div class="content-left">
                                    <h7> Country </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->shipping_country}} </h7>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="billing">
                        <div class="d-block mb-5">
                            <h6> Billing </h6>
                            <hr class="m-t-5 float-left" width="50%">
                        </div>
                        <div class="billing-content">
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Name </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_name}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Email </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_email}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Phone </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_phone}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> City </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_city}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> State </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_state}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-1">
                                <div class="content-left">
                                    <h7> Zip Code </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_zip_code}} </h7>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-2">
                                <div class="content-left">
                                    <h7> Country </h7>
                                </div>
                                <div class="content-right">
                                    <h7> : {{$product_info->customer_country}} </h7>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--Billing and shipping -->


