@if($status != 'shopify_pending')
    <div class="row">
        <div class="col-12">
            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                <div class="row-expand-height-control">
                    <!--start row expand inner table-->
                    <table class="product-draft-table row-expand-table w-100">
                        <thead>
                        <tr>
                            <th class="sku" style="width: 15%; text-align: center !important;">SKU</th>
                            <th class="qr" style="width: 15%; text-align: center !important;">QR</th>
                            <th class="variation" style="width: 20%; text-align: center !important;">Variation</th>
                            <th class="start-price" style="width: 15%; text-align: center !important;">Start Price</th>
                            <th class="sold" style="width: 15%; text-align: center !important;">Sold</th>
                            <th class="qty" style="width: 15%; text-align: center !important;">Available Qty</th>
{{--                            @if($shelfUse == 1)--}}
{{--                                <th class="shelf-qty" style="width: 15%; text-align: center !important;">Shelf Qty</th>--}}
{{--                            @endif--}}
                            <th style="width: 10%">Actions</th>
                        </tr>
                        </thead>

                        <!-- start row expand inner table body-->
                        <tbody>
                        @if(isset($product_list) && count($product_list) > 0)
                            @foreach($product_list as $product_variation)
                                @php
                                    $woo_variation_id = \App\ProductVariation::where('sku',$product_variation->sku)->first();
                                    if(isset($woo_variation_id)){
                                        $shelf_quantity = \App\ShelfedProduct::with('shelf_info')->where('variation_id',$woo_variation_id->id)->get();
                                        $data = \App\ShelfedProduct::where('variation_id',$woo_variation_id->id)->sum('quantity');
                                    }
                                @endphp
                                <tr>
                                    <td class="sku" style="width: 15%; text-align: center !important;">
                                        <div class="sku_tooltip_container d-flex justify-content-center">
                                            <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                            <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                        </div>
                                    </td>
                                    <td class="qr" style="width: 15%; text-align: center !important;">
                                        <div class="py-2"><a target="_blank" href="{{url('print-barcode/'.$product_variation->master_variation_id)}}">
                                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                            </a>

                                        </div>
                                    </td>
                                    <td class="variation" style="width: 20%; text-align: center !important;">
                                        @if(isset($product_variation->variation_specifics) && $product_variation->variation_specifics != "")
                                            @foreach(unserialize($product_variation->variation_specifics) as $key => $value)
                                                <label><b style="color: #7e57c2">{{$key}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$value}}, </label>
                                            @endforeach
                                        @endif
                                        {{--                                                @if(isset($product_variation->attribute2_name))--}}
                                        {{--                                                    <label><b style="color: #7e57c2">{{$product_variation->attribute2_name}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$product_variation->attribute2_value}}, </label>--}}
                                        {{--                                                @endif--}}
                                    </td>
                                    <td class="start-price" style="width: 15%; text-align: center !important;">{{$product_variation->start_price}}</td>
                                    {{--                                            <td>{{$product_variation->condition}}</td>--}}
                                    {{--                                            @if($product_variation->stock < $product_variation->low_quantity)--}}
                                    {{--                                                <td>{{$product_variation->stock}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>--}}
                                    {{--                                            @else--}}
                                    {{--                                                <td>{{$product_variation->quantity}}</td>--}}
                                    {{--                                            @endif--}}
                                    <td class="sold" style="width: 15%; text-align: center !important;">{{$product_variation->order_product_count ?? 0}}</td>
                                    <td class="qty" style="width: 15%; text-align: center !important;">{{$product_variation->quantity}}</td>
{{--                                    @if($shelfUse == 1)--}}
{{--                                        <td class="shelf-qty" style="width: 15%; text-align: center !important;">{{$data}}</td>--}}
{{--                                    @endif--}}
                                    <td style="width: 10%">
                                        <!--start manage button area-->
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn manage-btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <!--start dropup content-->
                                            <div class="dropdown-menu ebay-active-product">
                                                <div class="dropup-content ebay-dropup-content">
                                                    <div class="action-1">
                                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('variation-edit/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
{{--                                                        @if($shelfUse == 1)--}}
{{--                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->sku}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>--}}
{{--                                                        @endif--}}
                                                        <div class="align-items-center"><a class="btn-size delete-btn" href="{{url('ebay-variation-product-delete/'.$id.'/'.$product_variation->sku)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Delete variation"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End dropup content-->
                                        </div>
                                        <!--End manage button area-->
                                    </td>

                                    <!--start modal-->
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

                                                                    @isset($shelf_quantity)
                                                                        @foreach($shelf_quantity as $shelf)
                                                                            @if($shelf->quantity != 0)
                                                                                <div class="row">
                                                                                    <div class="col-6 text-center">
                                                                                        <h7> {{$shelf->shelf_info->shelf_name}} </h7>
                                                                                    </div>
                                                                                    <div class="col-6 text-center">
                                                                                        <h7> {{$shelf->quantity}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endisset
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
                                    </div>  <!-- End The Modal -->
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <!-- End row expand inner table body-->
                    </table>
                    <!--End  row expand inner table-->
                </div>
            </div> <!-- end card -->
        </div> <!-- end col-12 -->
    </div> <!-- end row -->
@else
    <!--hidden row -->
    <div class="row">
        <div class="col-12">
            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                <span class="screen-option"></span>
                <div class="row-expand-height-control">
                    <!--row expand inner table-->
                    <table class="product-draft-table row-expand-table w-100">
                        <thead>
                        <tr>
                            <th class="id" style="text-align: center !important; width: 7%;">ID</th>
                            <th class="sku" style="width: 10%">SKU</th>
                            <th class="qr" style="width: 7%;">QR</th>
                            <th class="variation" style="width: 10%">Variation</th>
{{--                            <th class="ean" style="width: 10% !important; text-align: center !important;">EAN</th>--}}
                            <th class="regular-price" style="width: 10% !important; text-align: center !important;">Regular Price</th>
                            <th class="sales-price" style="width: 10% !important; text-align: center !important;">Sales Price</th>
                            <th class="sold" style="width: 5% !important; text-align: center !important;">Sold</th>
                            <th class="available-qty" style="width: 10% !important; text-align: center !important;">Available Qty</th>
{{--                            @if($shelfUse == 1)--}}
{{--                                <th class="shelf-qty" style="width: 10% !important; text-align: center !important;">Shelf Qty</th>--}}
{{--                            @endif--}}
                            <th style="width: 6%">Actions</th>
                        </tr>
                        </thead>

                        <!--row expand inner table body-->
                        <tbody>
                        @if(isset($product_draft) && count($product_draft) > 0)
                            @foreach($product_draft as $product_variation)
                                @php
                                    $data = \App\ShelfedProduct::where('variation_id',$product_variation->id)->sum('quantity');

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
                                    <td class="qr" style="width: 7%;">
                                        <div class="pt-2 pb-2"><a target="_blank" href="{{url('print-barcode/'.$product_variation->id)}}">
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
{{--                                    <td class="ean" style="width: 10%; text-align: center !important;">{{$product_variation->ean_no}}</td>--}}
                                    <td class="regular-price" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="shown" id="regular_price_{{$product_variation->id}}">
                                                 <span>
                                                     {{$product_variation->regular_price}}
                                                     @php
                                                         $ids = '"'.$product_variation->id.'/regular_price"';
                                                     @endphp
                                                 </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="sales-price" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="shown" id="sale_price_{{$product_variation->id}}">
                                                 <span>
                                                     {{$product_variation->sale_price}}
                                                     @php
                                                         $ids = '"'.$product_variation->id.'/sale_price"';
                                                     @endphp
                                                 </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="sold" style="width: 5% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                    <td class="available-qty" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="shown" id="actual_quantity_{{$product_variation->id}}">
                                                 <span>
                                                     {{$product_variation->quantity}}
                                                     @php
                                                         $ids = '"'.$product_variation->id.'/actual_quantity"';
                                                     @endphp
                                                 </span>
                                            </div>
                                        </div>
                                    </td>
{{--                                    @if($shelfUse == 1)--}}
{{--                                        @if($product_variation->notification_status == 1 && $data < $product_variation->low_quantity)--}}
{{--                                            <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>--}}
{{--                                        @else--}}
{{--                                            <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}</td>--}}
{{--                                        @endif--}}
{{--                                    @endif--}}

                                    <td class="actions" style="width: 6%">
                                        <!--start manage button area-->
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Manage
                                            </button>
                                            <!--start dropup content-->
                                            <div class="dropdown-menu catalogue-active-catalogue">
                                                <div class="dropup-content catalogue-dropup-content">
                                                    <div class="action-1">
                                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('variation-edit/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
{{--                                                        @if($shelfUse == 1)--}}
{{--                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>--}}
{{--                                                        @endif--}}
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
                                            <!--End dropup content-->
                                        </div>
                                        <!--End manage button area-->
                                    </td>

                                    <!--Start modal-->
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
                                                                        <div class="col-3 text-center">
                                                                            <h6>Action</h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                    </div>
                                                                    @if(isset($product_variation->shelf_quantity))
                                                                        @foreach($product_variation->shelf_quantity as $shelf)
                                                                            @if($shelf->pivot->quantity != 0)
                                                                                @php
                                                                                    $ids = '"'.$product_variation->id.'_'.$shelf->pivot->id.'"';
                                                                                @endphp
                                                                                <div class="row">
                                                                                    <div class="col-3 text-center m-b-10">
                                                                                        <h7> {{$shelf->shelf_name}} </h7>
                                                                                    </div>

                                                                                    <div class="col-3 text-center m-b-10">
                                                                                        <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-3 text-center m-b-10">
                                                                                        <button type="button" class="btn btn-primary btn-sm change_quantity" id="{{$product_variation->id}}_{{$shelf->pivot->id}}" onclick="changeQuantity({{$ids}})">Change Quantity</button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif

                                                                    <div class="row p-20 change_quantity_div{{$product_variation->id}}" style="display: none;">
                                                                        <div class="col-12">
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
                                                                            <button type="button" class="btn btn-success" onclick="changeQuantityDiv({{$product_variation->id}})">Add</button>
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
                                    </div>
                                    <!--End modal-->
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <!--End row expand inner table body-->
                    </table>
                    <!--End row expand inner table-->
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


</script>
