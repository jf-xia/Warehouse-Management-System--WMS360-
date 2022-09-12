@extends('master')

@section('title')
    eBay Error Message | WMS360
@endsection

@section('content')


    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--Breadcrumb section-->
                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">eBay</li>
                            <li class="breadcrumb-item active" aria-current="page">Product with error message</li>
                        </ol>
                    </div>
{{--                    <div class="screen-option-btn">--}}
{{--                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
{{--                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>--}}
{{--                        </button>--}}
{{--                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>--}}
{{--                    </div>--}}
                </div>
                <!--End Breadcrumb section-->

                <!--Card box start-->
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box ebay table-responsive shadow">

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif


                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif


                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">
                                    <div class="ebay-master-product-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search on eBay...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search();">Search</button>
                                            </div>
                                        </form>
                                    </div>


                                    <!--Pagination area-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$master_product_list->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disabled'}}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disabled'}}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$master_decode_product_list->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="ebay-master-product-with-error-message-list">
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$master_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$master_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!--End Pagination area-->


                                </div>
                            </div>


                            <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div>



                            <h5 class="search_result_count"></h5>
                            <table class="ebay-table w-100">
                                <thead>
                                <tr>
                                    <th class="image text-center" style="width: 5%">Image</th>
                                    <th class="text-center" style="width: 10%">Eroor Message</th>
                                    <th class="item-id text-center" style="width: 10%">ID</th>
                                    <th class="catalogue-id text-center" style="width: 10%;">Catalogue ID</th>
                                    <th class="product-name" style="width: 20%">Product Name</th>
                                    <th class="category" style="width: 20%">Category</th>
                                    <th class="profile text-center" style="width: 10%">Profile </th>
                                    <th class="account text-center" style="width: 10%">Account</th>
                                    <th style="width: 5%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($master_product_list as $product_list)

                                    <tr>
                                        <td class="image text-center" style="width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                        @if(isset( \Opis\Closure\unserialize($product_list->master_images)[0]))
                                                <a href="#"  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}" class="ebay-image" alt="master-image"></a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image" alt="master-image">
                                            @endif
                                        </td>

{{--                                        <td class="error-id" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$product_list->change_message}}" class="accordion-toggle"><span id="master_opc_{{$product_list->change_message}}">{{$product_list->change_message}}</span></td>--}}
                                        <td class="error-id" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$product_list->change_message}}" class="accordion-toggle">
{{--                                            <span id="master_opc_{{$product_list->change_message}}"></span>--}}
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#errorMessage{{$product_list->id}}">
                                                Error message
                                            </button>
                                        </td>

                                        <td class="item-id" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            <span id="master_opc_{{$product_list->item_id}}">
                                                 <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->item_id}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </span>
                                        </td>

                                        <td class="catalogue-id" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->master_product_id}}</td>
                                        <td class="product-name" style="cursor: pointer;" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            <a href="https://www.ebay.co.uk/itm/{{$product_list->item_id}}" target="_blank">
                                                {!! Str::limit(strip_tags($product_list->title),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <td class="category" style="cursor: pointer; width: 20%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->category_name}}</td>
                                        <td class="profile text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            @isset(\App\EbayProfile::find($product_list->profile_id)->profile_name)
                                                {{\App\EbayProfile::find($product_list->profile_id)->profile_name}}
                                            @endisset
                                        </td>
                                        <td class="account text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            @isset(\App\EbayAccount::find($product_list->account_id)->account_name)
                                                {{\App\EbayAccount::find($product_list->account_id)->account_name}}
                                            @endisset
                                        </td>

                                        <td class="actions"  style="width: 5%">
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Dropdown menu links -->
                                                    <div class="dropup-content ebay-dropup-content">
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            {{--                                                <div class="align-items-center mr-2"> <a class="btn-success btn-size" href="{{url('onbuy/add-listings/'.$product_list->id)}}" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>--}}
                                                            {{--                                                <div class="align-items-center mr-2"> <a class="btn-success btn-size" href="{{url('onbuy/duplicate-master-product/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>--}}

                                                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('ebay-delete-listing/'.$product_list->id.'/'.$product_list->item_id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>

                                                            {{--                                                            <div><button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!--Error Messege Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="errorMessage{{$product_list->id}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Error Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
{{--                                                <div class="col-6">--}}
                                                    <div class="modal-body" style="overflow: overlay;">
                                                        {{$product_list->change_message}}
                                                    </div>
{{--                                                </div>--}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Error Messege Modal -->



                                    <!--hidden row -->
                                    <tr>
                                        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$product_list->id}}">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                            <div class="row-expand-height-control">
                                                                <table class="product-draft-table row-expand-table w-100">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="image" style="text-align: center !important; width: 6%;">Image</th>
                                                                        <th class="sku" style="width: 10%">SKU</th>
                                                                        <th class="qr" style="width: 10%">QR</th>
                                                                        <th class="variation" style="width: 15%">Variation</th>
                                                                        <th class="start_price" style="text-align: center !important;">start Price</th>
                                                                        <th class="quantity" style="text-align: center !important;">Quantity</th>
                                                                        <th style="width: 6%">Actions</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($product_list->variationProducts as $product_variation)
                                                                        @php
                                                                            $woo_variation_id = \App\ProductVariation::where('sku',$product_variation->sku)->first();
                                                                            if(isset($woo_variation_id)){
                                                                                $shelf_quantity = \App\ShelfedProduct::with('shelf_info')->where('variation_id',$woo_variation_id->id)->get();
                                                                                $data = \App\ShelfedProduct::where('variation_id',$woo_variation_id->id)->sum('quantity');
                                                                            }

                                                                        @endphp
                                                                        {{--                                         @if($data != 0)--}}
                                                                        <tr>
                                                                            {{--                                             <td class="text-justify">{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                                                            @if(unserialize($product_list->master_images) != null)
                                                                                <td class="image" style="text-align: center !important; width: 6%;">
                                                                                    <a href="{{unserialize($product_list->master_images)[0]}}"  title="Click to expand" target="_blank">
                                                                                        <img class="thumb-md" src="{{unserialize($product_list->master_images)[0]}}" height="60" width="60" alt="Responsive image">
                                                                                    </a>
                                                                                </td>
                                                                            @else
                                                                                <td class="image" style="text-align: center !important; width: 6%;">
                                                                                    <img class="thumb-md" src="{{asset('assets/common-assets/no_image.jpg')}}" height="60" width="60" alt="Responsive image">
                                                                                </td>
                                                                            @endif
                                                                            <td class="sku" style="width: 10%">
                                                                                <div class="sku_tooltip_container d-flex justify-content-start">
                                                                                    <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                                                                    <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                                                                </div>
                                                                            </td>
                                                                            <td class="qr" style="width: 10%">
                                                                                <div class="mt-2">
                                                                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product_variation->sku); !!}
                                                                                </div>
                                                                            </td>
                                                                            <td class="variation" style="width: 15%">
                                                                                @if(isset($product_variation->variation_specifics))
                                                                                    @foreach(unserialize($product_variation->variation_specifics) as $key => $value)
                                                                                        <label><b style="color: #7e57c2">{{$key}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$value}}, </label>
                                                                                    @endforeach

                                                                                @endif
                                                                                {{--                                                @if(isset($product_variation->attribute2_name))--}}
                                                                                {{--                                                    <label><b style="color: #7e57c2">{{$product_variation->attribute2_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute2_value}}, </label>--}}
                                                                                {{--                                                @endif--}}
                                                                            </td>
                                                                            <td class="start_price" style="text-align: center !important;">{{$product_variation->start_price}}</td>
                                                                            {{--                                            <td>{{$product_variation->condition}}</td>--}}
                                                                            {{--                                            @if($product_variation->stock < $product_variation->low_quantity)--}}
                                                                            {{--                                                <td>{{$product_variation->stock}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>--}}
                                                                            {{--                                            @else--}}
                                                                            {{--                                                <td>{{$product_variation->quantity}}</td>--}}
                                                                            {{--                                            @endif--}}
                                                                            <td class="quantity" style="text-align: center !important;">{{$product_variation->quantity}}</td>
                                                                            <td style="width: 6%">
                                                                                <div class="d-flex justify-content-start">
                                                                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                                    <div class="align-items-center mr-2"><a class="btn-size delete-btn" href="{{url('ebay-variation-product-delete/'.$product_list->id.'/'.$product_variation->sku)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Delete variation"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                                                    {{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('onbuy/variation-product-details/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>--}}
                                                                                    @if($shlefUse == 1)
                                                                                        <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->sku}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                                                    @endif
                                                                                    {{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-success" href="{{url('onbuy/add-listing/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Listing"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>--}}
                                                                                    {{--                                                    <div class="align-items-center mr-2"><a class="btn-size btn-danger" href="{{url('onbuy/delete-listing/'.$single_master_product_details->id.'/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Delete Listing" onclick="return check_delete('listing');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>--}}
                                                                                    {{--                                                    start--}}
                                                                                    {{--                                                                                                        <div class="align-items-center mr-2">--}}
                                                                                    {{--                                                                                                            <form action="" method="post">--}}
                                                                                    {{--                                                                                                                @csrf--}}
                                                                                    {{--                                                                                                                @method('DELETE')--}}
                                                                                    {{--                                                                                                                <button class="del-pub btn-danger" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash-o" aria-hidden="true"></i></button>--}}
                                                                                    {{--                                                                                                            </form>--}}
                                                                                    {{--                                                                                                        </div>--}}
                                                                                    {{--                                                    end--}}
                                                                                </div>
                                                                            </td>
                                                                            {{--                                            modal start--}}
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
                                                                            </div>  <!-- // The Modal -->
                                                                        </tr>
                                                                        {{--                                         @endif--}}
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div> <!-- end card -->
                                                    </div> <!-- end col-12 -->
                                                </div> <!-- end row -->
                                            </div> <!-- end accordion body -->
                                        </td> <!-- hide expand td-->
                                    </tr> <!-- hide expand row-->


                                @endforeach
                                </tbody>
                            </table>

                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num pr-1">{{$master_product_list->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disabled'}}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disabled'}}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex pl-1"> {{$master_decode_product_list->current_page}} of <span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                            <a class="next-page btn" href="{{$master_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$master_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                               </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End table below pagination sec-->

                        </div>
                    </div>
                </div>
                <!--End Card box start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->

    <script type="text/javascript">


        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })





        function check_queue_id(id) {
            console.log(id);
            $.ajax({
                type: "POST",
                url: "{{url('onbuy/check-queue-id')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "queue_id": id
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    if(response.status == 'success') {
                        console.log(response.status);
                        $('#master_opc_'+id).html(response.opc);
                        $('#status_show_'+id).html(response.status);
                    }else{
                        $('#status_show_'+id).html(response.status);
                    }
                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }

        function catalogue_search(){
            var search_value = $('#search_value').val();
            if(search_value == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            // var category_id = $('#category_id').val();
            console.log(status);
            $.ajax({
                type: "POST",
                url: "{{url('ebay-master-product-search')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "name": search_value
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    if(response.content != 'error') {

                        $('table tbody').html(response.content);
                        $('h5.search_result_count').removeClass('text-danger').html('');
                        $('h5.search_result_count').addClass('text-success').html('Result found '+response.total_row);

                        // $('h5.search_result_count').html('Result found '.response.total_row);
                    }else{
                        $('h5.search_result_count').removeClass('text-success').html('');
                        $('h5.search_result_count').addClass('text-danger').html('Result not found ');

                        // $('h5.search_result_count').html('Result found '.response.total_row);
                    }
                },complete: function () {
                    $("#ajax_loader").hide();
                }
            });
        }



        //Datatable row-wise searchable option
        // $(document).ready(function(){
        //     $("#row-wise-search").on("keyup", function() {
        //         let value = $(this).val().toLowerCase();
        //         $("#table-body tr").filter(function() {
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //         });
        //
        //     });
        // });

        //table header-search option toggle
        // $(document).ready(function(){
        //     $(".header-search").click(function(){
        //         $(".header-search-content").toggle();
        //     });
        // });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

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


        // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });


        // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });


        //sort ascending and descending table rows js
        // function sortTable(n) {
        //     let table,
        //         rows,
        //         switching,
        //         i,
        //         x,
        //         y,
        //         shouldSwitch,
        //         dir,
        //         switchcount = 0;
        //     table = document.getElementById("table-sort-list");
        //     switching = true;
        //     //Set the sorting direction to ascending:
        //     dir = "asc";
        //     /*Make a loop that will continue until
        //     no switching has been done:*/
        //     while (switching) {
        //         //start by saying: no switching is done:
        //         switching = false;
        //         rows = table.getElementsByTagName("TR");
        //         /*Loop through all table rows (except the
        //         first, which contains table headers):*/
        //         for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.
        //             //start by saying there should be no switching:
        //             shouldSwitch = false;
        //             /*Get the two elements you want to compare,
        //             one from current row and one from the next:*/
        //             x = rows[i].getElementsByTagName("TD")[n];
        //             y = rows[i + 1].getElementsByTagName("TD")[n];
        //             /*check if the two rows should switch place,
        //             based on the direction, asc or desc:*/
        //             if (dir == "asc") {
        //                 if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             } else if (dir == "desc") {
        //                 if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
        //                     //if so, mark as a switch and break the loop:
        //                     shouldSwitch = true;
        //                     break;
        //                 }
        //             }
        //         }
        //         if (shouldSwitch) {
        //             /*If a switch has been marked, make the switch
        //             and mark that a switch has been done:*/
        //             rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        //             switching = true;
        //             //Each time a switch is done, increase this count by 1:
        //             switchcount++;
        //         } else {
        //             /*If no switching has been done AND the direction is "asc",
        //             set the direction to "desc" and run the while loop again.*/
        //             if (switchcount == 0 && dir == "asc") {
        //                 dir = "desc";
        //                 switching = true;
        //             }
        //         }
        //     }
        // }


        // sort ascending descending icon active and active-remove js
        // $('.header-cell').click(function() {
        //     let isSortedAsc  = $(this).hasClass('sort-asc');
        //     let isSortedDesc = $(this).hasClass('sort-desc');
        //     let isUnsorted = !isSortedAsc && !isSortedDesc;
        //
        //     $('.header-cell').removeClass('sort-asc sort-desc');
        //
        //     if (isUnsorted || isSortedDesc) {
        //         $(this).addClass('sort-asc');
        //     } else if (isSortedAsc) {
        //         $(this).addClass('sort-desc');
        //     }
        // });


    </script>



@endsection
