@if($status == 'active')
    <div class="row">
        <div class="col-12">
            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                <div class="row-expand-height-control">
                    <!--start row expand inner table-->
                    <table class="product-draft-table row-expand-table w-100">
                        <thead>
                        <tr>
                            <th class="opc" style="width: 7% !important; text-align: center !important;">OPC</th>
                            <th class="sku" style="width: 15%">SKU</th>
                            <th class="qr" style="width: 7%">QR</th>
                            <th class="variation" style="width: 7%">Variation</th>
                            <th class="rrp" style="width: 7%; text-align: center !important;">RRP</th>
                            <th class="sales-price px-3" style="width: 7% !important; text-align: center !important;">Sales Price</th>
                            <th class="variation_base_price px-3" style="width: 7% !important; text-align: center !important;">Base Price</th>
                            <th class="variation_max_price px-3" style="width: 7% !important; text-align: center !important;">Max Price</th>
                            <th class="condition" style="width: 7% !important; text-align: center !important;">Condition</th>
                            <th class="qty" style="width: 8% !important; text-align: center !important;">Quantity</th>
                            <th class="boost_listing_commission" style="width: 7% !important; text-align: center !important;">Boost Commission</th>
                            <th class="lead_listing px-2" style="width: 7% !important; text-align: center !important;">Lead</th>
                            <th style="width: 7% !important; text-align: center !important;">Actions</th>
                        </tr>
                        </thead>

                        <!-- start row expand inner table body-->
                        <tbody>
                        @isset($product_list)
                            @foreach($product_list as $product_variation)
                                @php
                                    $woo_variation_id = \App\ProductVariation::where('sku',$product_variation->sku)->first();
                                    $shelf_quantity = [];
                                    if($woo_variation_id){
                                        $shelf_quantity = \App\ShelfedProduct::with('shelf_info')->where('variation_id',$woo_variation_id->id)->get();
                                        $data = \App\ShelfedProduct::where('variation_id',$woo_variation_id->id)->sum('quantity');
                                    }
                                @endphp
                                <tr class="@if($product_variation->lead_listing == 0) text-white  bg-danger @elseif($product_variation->lead_listing == 1) bg-success @elseif($product_variation->lead_listing == 2) bg-warning @else bg-primary @endif" style="border-bottom: 1px solid #dee2e6!important">
                                    <td class="opc" style="width: 7% !important; text-align: center !important;">
                                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button id_copy_button_OnBuy_opc">{{$product_variation->opc}}</span>
                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                        </div>
                                    </td>
                                    <td class="sku" style="width: 15%">
                                        <div class="sku_tooltip_container d-flex justify-content-start">
                                            <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                            <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                        </div>
                                        @if ($product_variation->updated_sku)
                                            <div class="sku_tooltip_container d-flex justify-content-start">
                                                <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">( Updated SKU: {{$product_variation->updated_sku}} )</span>
                                                <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="qr" style="width: 7%">
                                        <div class="py-2"><a target="_blank" href="{{url('print-barcode/'.$product_variation->id)}}">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                        </a>

                                        </div>
                                    </td>
                                    <td class="variation" style="width: 7%">
                                        @if(isset($product_variation->attribute1_name))
                                            <label><b>{{$product_variation->attribute1_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$product_variation->attribute1_value}}, </label>
                                        @endif
                                        @if(isset($product_variation->attribute2_name))
                                            <label><b>{{$product_variation->attribute2_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$product_variation->attribute2_value}}, </label>
                                        @endif
                                    </td>
                                    <td class="rrp" style="width: 7% !important; text-align: center !important;">{{$product_variation->price}}</td>
                                    <td class="sales-price px-3" style="width: 7% !important; text-align: center !important;">{{$product_variation->sale_price ?? ''}}<p style="font-size: 12px;">{{$product_variation->sale_start_date ? 'Start: '.date('Y-m-d',strtotime($product_variation->sale_start_date)) : ''}}{{$product_variation->sale_end_date ? ' / End: '.date('Y-m-d',strtotime($product_variation->sale_end_date)) : ''}}</p></td>
                                    <td class="variation_base_price px-3" style="width: 7% !important; text-align: center !important;">{{$product_variation->base_price ?? ''}}</td>
                                    <td class="variation_max_price px-3" style="width: 7% !important; text-align: center !important;">{{$product_variation->max_price ?? ''}}</td>
                                    <td class="condition"  style="width: 7% !important; text-align: center !important;">{{$product_variation->condition}}</td>
                                    @if($product_variation->stock < $product_variation->low_quantity)
                                        <td class="qty" style="width: 8% !important; text-align: center !important;">{{$product_variation->stock}}<br><span class="label label-table label-purple">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                    @else
                                        <td class="qty" style="width: 8% !important; text-align: center !important;">{{$product_variation->stock}}</td>
                                    @endif
                                    <td class="boost_listing_commission"  style="width: 7% !important; text-align: center !important;">{{$product_variation->boost_marketing_commission ?? ''}}</td>
                                    <td class="lead_listing px-2"  style="width: 7% !important; text-align: center !important;">{{($product_variation->lead_listing) == 0 ? 'No' : ($product_variation->lead_listing != '' ? 'Yes' : '')}}</td>
                                    <td class="actions" style="width: 7% !important; text-align: center !important;">
                                        <!--start manage button area-->
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn manage-btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <!--start dropup content-->
                                            <div class="dropdown-menu onbuy-active-product">
                                                <div class="dropup-content onbuy-dropup-content">
                                                    <div class="action-1">
                                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-variation-product/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('onbuy/variation-product-details/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                        @if($shelfUse == 1)
                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->sku}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                        @endif
                                                        <div class="align-items-center mr-2"><a class="btn-size add-product-btn" href="{{url('onbuy/add-listing/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Listing"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center"><a class="btn-size delete-btn" href="{{url('onbuy/delete-listing/'.$id.'/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Delete Listing" onclick="return check_delete('listing');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End dropup content-->
                                        </div>
                                        <!--End manage button area-->
                                    </td>
                                    <div class="modal fade" id="myModal{{$product_variation->sku}}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Shelf Product</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                <div style="border: 1px solid #ccc;">
                                                                    <div class="row m-t-10">
                                                                        <div class="col-6 text-center">
                                                                            <h6> Shelf Name </h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <div class="col-6 text-center">
                                                                            <h6>Quantity</h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                    </div>
                                                                    @php

                                                                        @endphp
                                                                    @if(count($shelf_quantity) > 0)
                                                                        @foreach($shelf_quantity as $shelf)
                                                                            @if($shelf->quantity != 0)
                                                                                <div class="row">
                                                                                    <div class="col-6 text-center">
                                                                                        <h7> {{$shelf->shelf_info->shelf_name ?? ''}} </h7>
                                                                                    </div>
                                                                                    <div class="col-6 text-center">
                                                                                        <h7> {{$shelf->quantity}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div> <!-- end card -->
                                                        </div> <!-- end col-12 -->
                                                    </div> <!-- end row -->
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>  <!-- // The Modal -->
                                </tr>

                            @endforeach
                        @endisset
                        </tbody>
                        <!-- End row expand inner table body-->

                    </table>
                    <!--End row expand inner table-->
                </div>
            </div> <!-- end card -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@elseif($status == 'onbuy_ean_pending')
    <div class="row">
        <div class="col-12">
            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                <div class="row-expand-height-control">
                    <table class="product-draft-table row-expand-table w-100">
                        <thead>
                        <tr>
                            <th class="id" style="text-align: center !important; width: 7%;">ID</th>
                            <th class="sku" style="width: 10%">SKU</th>
                            <th class="qr" style="width: 10%">QR</th>
                            <th class="variation" style="width: 10%">Variation</th>
                            <th class="ean" style="width: 7%">EAN</th>
                            <th class="regular-price" style="width: 10% !important; text-align: center !important;">Regular Price</th>
                            <th class="sales-price" style="width: 10% !important; text-align: center !important;">Sales Price</th>
                            <th class="sold" style="width: 5% !important; text-align: center !important;">Sold</th>
                            <th class="available-qty" style="width: 10% !important; text-align: center !important;">Available Qty</th>
                            @if($shelfUse == 1)
                                <th class="shelf-qty" style="width: 10% !important; text-align: center !important;">Shelf Qty</th>
                            @endif
                            <th style="width: 6%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(count($catalogue) > 0)
                            @foreach($catalogue as $product_variation)
                                @php
                                    $data = \App\ShelfedProduct::where('variation_id',$product_variation->id)->sum('quantity');
                                    $total_sold = 0;
                                    /*foreach ($product_variation->order_products as $product){
                                        $total_sold += $product->sold;
                                    }*/
                                @endphp
                                <tr>
                                    <td class="id" style="text-align: center !important; width: 7%;">
                                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_variation->id}}</span>
                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                        </div>
                                    </td>
                                    <td class="sku" style="width: 10%">
                                        <div class="sku_tooltip_container d-flex justify-content-start">
                                            <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                            <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                        </div>
                                    </td>
                                    <td class="qr" style="width: 10%">
                                        <div class="py-2"><a target="_blank" href="{{url('print-barcode/'.$product_variation->id)}}">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                        </a>

                                        </div>
                                    </td>
                                    <td class="variation" style="width: 10%">
                                        @isset($product_variation->attribute)
                                            @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute_value)
                                                <label><b style="color: #7e57c2">{{$attribute_value['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute_value['terms_name']}}, </label>
                                            @endforeach
                                        @endisset
                                    </td>
                                    <td class="ean" style="width: 7%">{{$product_variation->ean_no}}</td>
                                    <td class="regular-price" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="shown" id="regular_price_{{$product_variation->id}}">{{$product_variation->regular_price}}</span>
                                        </div>
                                    </td>
                                    <td class="sales-price" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="shown" id="sale_price_{{$product_variation->id}}">{{$product_variation->sale_price}}</span>
                                        </div>
                                    </td>
                                    <td class="sold" style="width: 5% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                    <td class="available-qty" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="shown" id="actual_quantity_{{$product_variation->id}}">{{$product_variation->actual_quantity}}</span>
                                        </div>
                                    </td>

                                    @if($shelfUse == 1)
                                        @if($product_variation->notification_status == 1 && $data < $product_variation->low_quantity)
                                            <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                        @else
                                            <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}</td>
                                        @endif
                                    @endif

                                    {{--                                             <td>{{$product_variation->low_quantity}}</td>--}}
                                    <td class="actions" style="width: 6%">
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <div class="dropdown-menu onbuy-pending-product">
                                                <div class="dropup-content catalogue-dropup-content">
                                                    <div class="action-1">
                                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-variation.edit',$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                        @if($shelfUse == 1)
                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                        @endif
                                                        <div class="align-items-center mr-2"><a class="btn-size invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class="fa fa-book" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center">
                                                            <form action="{{route('product-variation.destroy',$product_variation->id)}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="myModal{{$product_variation->id}}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Shelf Product</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                <div style="border: 1px solid #ccc;">
                                                                    <div class="row m-t-10">
                                                                        <div class="col-3 text-center">
                                                                            <h6> Shelf Name </h6>
                                                                            <hr width="60%">
                                                                        </div>

                                                                        <div class="col-3 text-center">
                                                                            <h6>Quantity</h6>
                                                                            <hr width="20%">
                                                                        </div>
                                                                        {{--                                                                                                                <div class="col-3 text-center">--}}
                                                                        {{--                                                                                                                    <h6>Action</h6>--}}
                                                                        {{--                                                                                                                    <hr width="60%">--}}
                                                                        {{--                                                                                                                </div>--}}
                                                                    </div>
{{--                                                                    @foreach($product_variation->shelf_quantity as $shelf)--}}
{{--                                                                        @if($shelf->pivot->quantity != 0)--}}
{{--                                                                            <div class="row">--}}
{{--                                                                                <div class="col-3 text-center m-b-10">--}}
{{--                                                                                    <h7> {{$shelf->shelf_name}} </h7>--}}
{{--                                                                                </div>--}}

{{--                                                                                <div class="col-3 text-center m-b-10">--}}
{{--                                                                                    <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>--}}
{{--                                                                                </div>--}}
{{--                                                                                --}}{{--                                                                                                                        <div class="col-3 text-center m-b-10">--}}
{{--                                                                                --}}{{--                                                                                                                            <button type="button" class="btn btn-primary btn-sm change_quantity" id="{{$product_variation->id}}_{{$shelf->pivot->id}}">Change Quantity</button>--}}
{{--                                                                                --}}{{--                                                                                                                        </div>--}}
{{--                                                                            </div>--}}
{{--                                                                        @endif--}}
{{--                                                                    @endforeach--}}


                                                                    <div class="row p-20 change_quantity_div" style="display: none;">
                                                                        <div class="col-12">
                                                                            {{--                                                                                     <form action="Javascript:void(0);">--}}
                                                                            <h3>Change Info:</h3><span></span>
                                                                            <hr>
                                                                            <div class="form-group">
                                                                                <label class="required">Quantity</label>
                                                                                <input type="text" class="form-control c_quantity_{{$product_variation->id}}" name="c_quantity" id="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Reason</label>
                                                                                <textarea class="form-control" name="c_reason" id="c_reason" cols="5" rows="3"></textarea>
                                                                            </div>

                                                                            <button type="button" class="btn btn-success">Add</button>
                                                                            {{--                                                                                     </form>--}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- end card -->
                                                        </div> <!-- end col-12 -->
                                                    </div> <!-- end row -->
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>  <!-- // The Modal -->
                                </tr>
                                {{--                                         @endif--}}
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@endif
<script>

    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });

    //table column by default hide
    $("input:checkbox:not(:checked)").each(function() {
        var column = "table ." + $(this).attr("name");
        $(column).hide();
    });

    //prevent onclick dropdown menu close
    $('.filter-content').on('click', function(event){
        event.stopPropagation();
    });

    //Table inner variation price edit hover content fixed jquery
    (function($) {
        var activeHover;
        $('.shown span').on('mouseenter',
            function () {
                if ($(this).index() === activeHover) {
                    return;
                }
                $('.shown span').removeClass('contentHover');
                $(this).addClass('contentHover');
            });
    })(jQuery);
    //End Table inner variation price edit hover content fixed jquery

</script>
