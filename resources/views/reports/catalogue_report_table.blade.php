@extends('master')
@section('title')
    Catalogue | Reports | WMS360
@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="wms-breadcrumb">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Reports</li>
                        </ol>
                    </div>
                </div>
                <div class="row m-t-20 report">
                    <div class="col-md-12">
                        <div class="card-box py-5 shadow">
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
                                <div class="col-lg-6" style="display: inline-block;">

                                </div>
                                <div class="col-lg-6" style="float:right; margin-bottom: 20px;">
                                    <form action="{{URL('global_reports/download-catalouge-report-csv')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{$start_date}}">
                                        <input type="hidden" name="end_date" value="{{$end_date}}">
                                        <input type="hidden" name="unsold_start_date" value="{{$unsold_start_date}}">
                                        <input type="hidden" name="unsold_end_date" value="{{$unsold_end_date}}">
                                        <button class="waves-effect waves-light" type="submit" style="float: right; background: green; padding: 10px; color: #fff; border: none;">Download CSV</button>
                                    </form>
                                </div>
                            <!--Pagination area start-->
                                <div class="pagination-area" style="float: right">
                                <!-- {{$product_drafts->appends(request()->all())->render()}} -->
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$product_drafts->total() ?? ''}} items</span>
                                            <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->first_page_url.$url : $product_drafts_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->prev_page_url.$url : $product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$product_drafts_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$product_drafts_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="completed-catalogue-list">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($product_drafts->currentPage() !== $product_drafts->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $product_drafts_info->next_page_url.$url : $product_drafts_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $product_drafts_info->last_page_url.$url : $product_drafts_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                @endif
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <!--End Pagination area-->
                            <!--Start Table-->
                                <table class="draft_search_result product-draft-table w-100 ">
                                <!--start table head-->
                                <thead style="background-color: {{$setting->master_publish_catalogue->table_header_color ?? '#c5bdbd'}}; color: {{$setting->master_publish_catalogue->table_header_text_color ?? '#292424'}}">
                                <form action="" method="post" id="reset-column-data">
                                    @csrf
                                    <input type="hidden" name="search_route" value="completed-catalogue-list">
                                    <input type="hidden" name="status" value="publish">
                                    <tr>
                                        <th class="image" style="width: 6%; text-align: center !important;">Image</th>
                                        <th class="id" style="width: 6%; text-align: center !important;">
                                            <div class="d-flex justify-content-center">

                                                <div>ID</div>
                                            </div>
                                        </th>

                                        <th class="channel" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div>Channel</div>
                                            </div>
                                        </th>

                                        <th class="product-type" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div>Product Type</div>
                                            </div>
                                        </th>

                                        <th class="catalogue-name" style="width: 30%;">
                                            <div class="d-flex justify-content-start">
                                                <div> Title</div>
                                            </div>
                                        </th>

                                        <th class="category" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div>Category</div>
                                            </div>
                                        </th>

                                        <th class="rrp filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>RRP</div>
                                            </div>
                                        </th>

                                        <th class="base_price filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>Base Price</div>
                                            </div>
                                        </th>
                                        <th class="base_price filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>Cost Price</div>
                                            </div>
                                        </th>

                                        <th class="sold filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>Sold</div>
                                            </div>
                                        </th>

                                        <th class="stock filter-symbol" style="width: 10% !important; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>Stock</div>
                                            </div>
                                        </th>

                                        <th class="product filter-symbol" style="width: 10% !important; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div>Product</div>
                                            </div>
                                        </th>

                                        <th class="creator filter-symbol" style="width: 8% !important;">
                                            <div class="d-flex justify-content-start">
                                                <div>Creator</div>
                                            </div>
                                        </th>
                                        <th class="modifier filter-symbol" style="width: 8% !important;">
                                            <div class="d-flex justify-content-start">
                                                <div>Modifier</div>
                                            </div>
                                        </th>
                                        <th style="width: 6%">
                                            <div class="d-flex justify-content-center">
                                                <div>Actions</div> &nbsp; &nbsp;
                                            </div>
                                        </th>
                                    </tr>
                                </form>
                                </thead>
                                <!--End table head-->


                                <!--start table body-->
                                <tbody id="search_reasult" class="scrollbar-lg">
                                @isset($product_drafts)
                                    @foreach($product_drafts as $key=> $product_draft)

                                        <tr class="variation_load_tr">
                                            <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;"  data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">

                                                <!--Start each row loader-->
                                                <div id="product_variation_loading{{$product_draft->id}}" class="variation_load" style="display: none;"></div>
                                                <!--End each row loader-->

                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                @if(isset($product_draft->single_image_info->image_url))
                                                    <a href="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                        <img src="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image">
                                                    </a>
                                                @else
                                                    <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                                                @endif
                                            </td>
                                            {{--                                        <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->id}}</td>--}}
                                            <td class="id" style="width: 7%; text-align: center !important">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_draft->id}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="channel" style="width: 10%, text-align: center !important">
                                                @if (Session::get('ebay') == 1)

                                                    @if(isset($product_draft->ebayCatalogueInfo[0]))
                                                        <div class="row mb-2">
                                                            @foreach($product_draft->ebayCatalogueInfo as $catalogueInfo)
                                                                @if($catalogueInfo->AccountInfo->account_name)
                                                                    <div class="col-md-4 mb-1">
                                                                        <a title="eBay({{$catalogueInfo->AccountInfo->account_name}})" href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" target="_blank">
                                                                            @if($catalogueInfo->product_status == "Active")
                                                                                @if(isset($catalogueInfo->AccountInfo->logo))
                                                                                    <img style="height: 30px; width: 30px;" src="{{$catalogueInfo->AccountInfo->logo}}">
                                                                                @else

                                                                                    <span class="account_trim_name">
                                                                                                            @php
                                                                                                                $ac = $catalogueInfo->AccountInfo->account_name;
                                                                                                                echo implode('', array_map(function($name)
                                                                                                                { return $name[0];
                                                                                                                },
                                                                                                                explode(' ', $ac)));
                                                                                                            @endphp
                                                                                                        </span>

                                                                                @endif
                                                                            @elseif($catalogueInfo->product_status == "Completed")
                                                                                @if($product_draft->ProductVariations[0]->stock == 0)
                                                                                    @if(isset($catalogueInfo->AccountInfo->logo))
                                                                                        <img style="height: 30px; width: 30px;" src="{{$catalogueInfo->AccountInfo->logo}}">
                                                                                    @else

                                                                                        <span class="account_trim_name">
                                                                                                            @php
                                                                                                                $ac = $catalogueInfo->AccountInfo->account_name;
                                                                                                                echo implode('', array_map(function($name)
                                                                                                                { return $name[0];
                                                                                                                },
                                                                                                                explode(' ', $ac)));
                                                                                                            @endphp
                                                                                                        </span>
                                                                                    @endif
                                                                                @endif
                                                                            @endif

                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="row">
                                                    @if (Session::get('woocommerce') == 1)
                                                        @isset($product_draft->woocommerce_catalogue_info)
                                                            <div class="col-md-4 mr-1">
                                                                <a title="WooCommerce" href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$product_draft->woocommerce_catalogue_info->id.'&action=edit'}}" class="form-group" target="_blank"><img style="height: auto; width: 40px;" src="https://www.pngitem.com/pimgs/m/533-5339688_icons-for-work-experience-png-download-logo-woocommerce.png"></a>
                                                            </div>
                                                        @endisset
                                                    @endif
                                                    @if (Session::get('onbuy') == 1)
                                                        @isset($product_draft->onbuy_product_info)
                                                            <div class="col-md-4">
                                                                <a title="OnBuy" href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$product_draft->onbuy_product_info->product_id.'/'}}" class="" target="_blank"><img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg"></a>
                                                            </div>
                                                        @endisset
                                                    @endif
                                                    @if (Session::get('amazon') == 1)
                                                        @isset($product_draft->amazonCatalogueInfo)
                                                            @foreach($product_draft->amazonCatalogueInfo as $amazon)
                                                                <div class="col-md-4">
                                                                    <a title="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})" href="{{asset('/').$amazon->applicationInfo->accountInfo->account_logo}}" class="form-group" target="_blank">
                                                                        <img style="height: 30px; width: 30px;" src="{{$amazon->applicationInfo->accountInfo->account_logo ? asset('/').$amazon->applicationInfo->accountInfo->account_logo : asset('/').$amazon->applicationInfo->application_logo}}" alt="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})">
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="product-type" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                                <div style="text-align: center;">
                                                    @if($product_draft->type == 'simple')
                                                        Simple
                                                    @else
                                                        Variation
                                                    @endif
                                                </div>


                                            </td>
                                            <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                                <a class="catalogue-link" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                <!-- {{ Str::limit($product_draft->name,60, $end = '...') }} -->
                                                    {{$product_draft->name}}
                                                </a>
                                            </td>
                                            <td class="category" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{json_decode($product_draft)->woo_wms_category->category_name ?? ''}}</td>
                                            @php
                                                $data = 0;
                                                if(count($product_draft->variations) > 0){
                                                    foreach ($product_draft->variations as $variation){
                                                        if(isset($variation->order_products) && (count($variation->order_products) > 0)){
                                                            foreach($variation->order_products as $product){
                                                                $data += $product->sold;
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <td class="rrp" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->rrp ?? ''}}</td>
                                            <td class="base_price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->base_price ?? ''}}</td>
                                            <td class="base_price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->cost_price ?? ''}}</td>
                                            <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$data ?? 0}}</td>
                                            <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->ProductVariations[0]->stock ?? 0}}</td>
                                            <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->product_variations_count ?? 0}}</td>
                                            <td class="creator" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                                <div class="wms-name-creator">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                        {{--                                                <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                        <strong class="text-success">{{$product_draft->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="modifier" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                                @if(isset($product_draft->modifier_info->name))
                                                    <div class="wms-name-modifier1">
                                                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->updated_at))}}">
                                                            {{--                                                    <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                            <strong class="text-success">{{$product_draft->modifier_info->name ?? ''}}</strong>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="wms-name-modifier2">
                                                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                            {{--                                                    <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                            <strong class="text-success">{{$product_draft->user_info->name ?? ''}}</strong>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="actions draft-list" style="width: 6%">
                                                <!--start manage button area-->
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <!--start dropup content-->
                                                    <div class="dropdown-menu">
                                                        <div class="dropup-content catalogue-dropup-content">
                                                            <div class="action-1">
                                                                {{--                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Channel Listing"><a class="btn-size channel-listing-view-btn" href="#" data-toggle="modal" target="_blank" data-target="#channelListing{{$product_draft->id ?? ''}}"><i class="fas fa-atom" aria-hidden="true"></i></a></div>--}}
                                                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-bulk-barcode/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                                @if (Session::get('onbuy') == 1)
                                                                    @if(!isset($product_draft->onbuy_product_info->id))
                                                                        @if($product_draft->product_variations_count != 0)
                                                                            <div class="align-items-center mr-2"> <a class="btn-size list-onbuy-btn" href="{{url('onbuy/create-product/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$product_draft->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div>
                                                            </div>
                                                            <div class="action-2">
                                                                @if (Session::get('woocommerce') == 1)
                                                                    @if(!isset($product_draft->woocommerce_catalogue_info->master_catalogue_id))
                                                                        @if($product_draft->product_variations_count != 0)
                                                                            <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Woocommerce"><i class="fab fa-wordpress" aria-hidden="true"></i></a></div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                @if (Session::get('shopify') == 1)
                                                                    @if($product_draft->product_variations_count != 0)
                                                                        <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('shopify/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Shopify"><i class="fab fa-shopify" aria-hidden="true"></i></a></div>
                                                                    @endif
                                                                @endif
                                                                <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                                                <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                                @if (Session::get('ebay') == 1)
                                                                    @if($product_draft->product_variations_count != 0)
                                                                        <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" href="{{url('create-ebay-product/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List on eBay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                                                    @endif
                                                                @endif
                                                                <div class="align-items-center">
                                                                    <form action="{{route('product-draft.destroy',$product_draft->id)}}" method="post" id="catalogueDelete{{$product_draft->id}}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteConfirmationMessage('catalogue','catalogueDelete{{$product_draft->id}}');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End dropup content-->
                                                </div>
                                                <!--End manage button area-->
                                            </td>
                                        </tr>

                                        <!--start hidden row-->
                                        <tr>
                                            <td  colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                                <div class="accordian-body collapse" id="demo{{$product_draft->id}}">


                                                </div>
                                            </td>
                                        </tr>
                                        <!--hidden row -->

                                        <!-- channel listing modal -->
                                        <div class="modal fade" id="channelListing{{$product_draft->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Channel Listing</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @isset($product_draft->woocommerce_catalogue_info)
                                                            <div>
                                                                <h5>Website </h5>
                                                                <a href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$product_draft->woocommerce_catalogue_info->id.'&action=edit'}}" class="btn btn-outline-secondary btn-sm ml-2" target="_blank">View On Website Admin</a>
                                                            </div>
                                                        @endisset
                                                        @if(isset($product_draft->ebayCatalogueInfo[0]))
                                                            <div>
                                                                <h5>eBay </h5>
                                                                @foreach($product_draft->ebayCatalogueInfo as $catalogueInfo)
                                                                    <div class="mb-2">
                                                                        <span>{{$catalogueInfo->AccountInfo->account_name}}</span>
                                                                        <a href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" class="btn btn-outline-warning btn-xs ml-2" target="_blank">View On eBay</a><br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        @isset($product_draft->onbuy_product_info)
                                                            <div>
                                                                <h5>OnBuy</h5>
                                                                <a href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$product_draft->onbuy_product_info->product_id.'/'}}" class="btn btn-outline-info btn-sm ml-2" target="_blank">View On OnBuy Admin</a>
                                                            </div>
                                                        @endisset
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    @endforeach
                                @endisset
                                </tbody>
                                <!--End table body-->

                            </table>
                            <!--End Table-->
                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area" style="float: right">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num"> {{$product_drafts->total() ?? ''}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                            <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->first_page_url.$url : $product_drafts_info->first_page_url}}}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                            <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->prev_page_url.$url : $product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                        @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$product_drafts_info->current_page}} of <span class="total-pages">{{$product_drafts_info->last_page}}</span></span>
                                                    </span>
                                                    @if($product_drafts->currentPage() !== $product_drafts->lastPage())
                                                            <a class="next-page btn" href="{{$url != '' ? $product_drafts_info->next_page_url.$url : $product_drafts_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                            <a class="last-page btn" href="{{$url != '' ? $product_drafts_info->last_page_url.$url : $product_drafts_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                        </div> <!--//End card-box -->
                    </div><!--//End col-md-12 -->
                </div><!--//End row -->
            </div> <!-- // End Container-fluid -->
        </div> <!-- // End Content -->
    </div> <!-- // End Contact page -->

    <script>
        // Select option dropdown
        $('.select2').select2();
        $(".unsold_cat_sku_account").select2({
            placeholder: "All Account",
        });

        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1]
            var searchKeyword = $('input#name').val();


            $.ajax({
                type: "post",
                url: "<?php echo e(url('get-variation')); ?>",
                data: {
                    "_token" : "<?php echo e(csrf_token()); ?>",
                    "product_draft_id" : id,
                    "searchKeyword" : searchKeyword

                },
                beforeSend: function () {
                    $('#product_variation_loading'+id).show();
                },
                success: function (response) {
                    // $('#datatable_wrapper div:first').hide();
                    // $('#datatable_wrapper div:last').hide();
                    // $('.product-content ul.pagination').hide();
                    // $('.total-d-o span').hide();
                    // $('.draft_search_result').html(response.data);

                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }

    </script>

@endsection
