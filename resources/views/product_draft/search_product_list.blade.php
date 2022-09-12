@if($status == 'draft' || $status == 'publish')
    @if(isset($search_result))
        @foreach($search_result as $search_result)
        @if(is_numeric($date) == TRUE)
            <tr class="hide-after-complete-{{$search_result->id}}">
                @if($status == 'publish')
                    <td><input type="checkbox" name="catalgueCheckbox" class="catalogueCheckbox checkBoxClass" value="{{$search_result->id}}"></td>
                @endif
                @if($status == 'draft')
                    <td><input type="checkbox" class="checkBoxClass" id="customCheck{{$search_result->id}}" value="{{$search_result->id}}"></td>
                @endif
                <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">

                    <!--Start each row loader-->
                    <div id="product_variation_loading{{$search_result->id}}" class="variation_load" style="display: none;"></div>
                    <!--End each row loader-->

                    @if(isset($search_result->single_image_info->image_url))
                        <a href="{{(filter_var($search_result->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$search_result->single_image_info->image_url : $search_result->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                            <img src="{{(filter_var($search_result->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$search_result->single_image_info->image_url : $search_result->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image">
                        </a>
                    @else
                        <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                    @endif

                </td>
    {{--            <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->id}}</td>--}}
                <td class="id" style="width: 7%; text-align: center !important">
                    <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$search_result->id}}</span>
                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                    </div>
                </td>
                @if($status == 'publish')
                <td class="channel" style="width: 10%; text-align: center !important">
                    @if(isset($search_result->ebayCatalogueInfo[0]))
                        <!-- <h5>eBay </h5> -->
                        <div class="row mb-2">
                            @foreach($search_result->ebayCatalogueInfo as $catalogueInfo)
                                @if(isset($catalogueInfo->AccountInfo->account_name))
                                    <div class="col-md-4 mb-1">
                                        <a title="eBay({{$catalogueInfo->AccountInfo->account_name}})" href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" target="_blank">
                                            @if($catalogueInfo->product_status == "Active")
                                                @if($catalogueInfo->AccountInfo->logo)
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
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        @isset($search_result->woocommerce_catalogue_info)
                            <div class="col-md-4 mr-1">
                                <a title="WooCommerce" href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$search_result->woocommerce_catalogue_info->id.'&action=edit'}}" class="form-group" target="_blank"><img style="height: 30px; width: 30px;" src="https://www.pngitem.com/pimgs/m/533-5339688_icons-for-work-experience-png-download-logo-woocommerce.png" ></a>
                            </div>
                        @endisset
                        @isset($search_result->onbuy_product_info)
                            <div class="col-md-4">
                                <a title="OnBuy" href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$search_result->onbuy_product_info->product_id.'/'}}" class="" target="_blank"><img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg"></a>
                            </div>
                        @endisset
                        @isset($search_result->amazonCatalogueInfo)
                            @foreach($search_result->amazonCatalogueInfo as $amazon)
                                <div class="col-md-4">
                                    <a title="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})" href="{{asset('/').$amazon->applicationInfo->accountInfo->account_logo}}" class="form-group" target="_blank">
                                        <img style="height: 30px; width: 30px;" src="{{$amazon->applicationInfo->accountInfo->account_logo ? asset('/').$amazon->applicationInfo->accountInfo->account_logo : asset('/').$amazon->applicationInfo->application_logo}}" alt="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})">
                                    </a>
                                </div>
                            @endforeach
                        @endisset
                        @isset($search_result->shopifyCatalogueInfo)
                            @foreach($search_result->shopifyCatalogueInfo as $shopify)

                                {{-- <h6>{{ $shopify->shopifyUserInfo->account_name ?? '' }}</h6> --}}
                                <div class="col-md-4">
                                    <a title="{{$shopify->shopifyUserInfo->account_name ?? ''}} ({{$shopify->shopifyUserInfo->account_name ?? ''}})" href="{{ $shopify->shopifyUserInfo->shop_url ?? '' }}" class="form-group" target="_blank">
                                        <img style="height: 30px; width: 30px; margin:10px;" src="{{$shopify->shopifyUserInfo->account_logo ?? ''}}" alt="{{$shopify->shopifyUserInfo->account_name ?? ''}} ({{$shopify->shopifyUserInfo->account_name ?? ''}})">
                                    </a>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </td>
                @endif
                <td class="product-type" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                    <div style="text-align: center;">
                        @if($search_result->type == 'simple')
                            Simple
                        @else
                            Variation
                        @endif
                    </div>
                </td>
                <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                    <a class="catalogue-link" href="{{route('product-draft.show',$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                        {{ Str::limit($search_result->name,100, $end = '...') }}
                    </a>
                </td>
                <?php
                //            $data = '';
                //            foreach ($search_result->all_category as $category){
                //                $data .= $category->category_name.',';
                //            }
                $total_sold = 0;
                foreach ($search_result->variations as $variations){
                    foreach ($variations->order_products as $order_products){
                        $total_sold += $order_products->sold;
                    }
                }
                ?>
                <td class="category" style="width: 10%; cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{json_decode($search_result)->woo_wms_category->category_name ?? ''}}</td>
                <td class="rrp" style="width: 10%; cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{ $search_result->rrp ?? ''}}</td>
                <td class="base_price" style="width: 10%; cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$search_result->base_price}}" onclick="getVariation(this)" data-target="#demo{{$search_result->base_price}}" class="accordion-toggle">{{ $search_result->base_price ?? ''}}</td>
                @if($status == 'publish')
                <td class="sold" id="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$total_sold ?? 0}}</td>
                @endif
                <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->ProductVariations[0]->stock ?? 0}}</td>
                <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->product_variations_count ?? 0}}</td>
                <td class="creator" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                    @if(isset($search_result->user_info->name))
                    <div class="wms-name-creator">
                        <div data-tip="on {{date('d-m-Y', strtotime($search_result->created_at))}}">
                            <strong class="@if($search_result->user_info->deleted_at) text-danger @else text-success @endif">{{$search_result->user_info->name ?? ''}}</strong>
                        </div>
                    </div>
                    @endif
                </td>
                <td class="modifier" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                    @if(isset($search_result->modifier_info->name))
                        <div class="wms-name-modifier1">
                            <div data-tip=" on {{date('d-m-Y', strtotime($search_result->updated_at))}}">
                                <strong class="@if($search_result->modifier_info->deleted_at) text-danger @else text-success @endif">{{$search_result->modifier_info->name ?? ''}}</strong>
                            </div>
                        </div>
                    @elseif(isset($search_result->user_info->name))
                        <div class="wms-name-modifier2">
                            <div data-tip="on {{date('d-m-Y', strtotime($search_result->created_at))}}">
                                <strong class="@if($search_result->user_info->deleted_at) text-danger @else text-success @endif">{{$search_result->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                    @endif
                </td>

                <td class="actions" style="width: 6%">
                    <!--start manage button area-->
                    <div class="btn-group dropup">
                        <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                        </button>
                        <!--start dropup content-->
                        <div class="dropdown-menu">
                            <div class="dropup-content catalogue-dropup-content">
                                <div class="action-1">
{{--                                    @if($status == 'publish')--}}
{{--                                    <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Channel Listing"><a class="btn-size channel-listing-view-btn" href="#" data-toggle="modal" target="_blank" data-target="#channelListing{{$search_result->id ?? ''}}"><i class="fas fa-atom" aria-hidden="true"></i></a></div>--}}
{{--                                    @endif--}}
                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-bulk-barcode/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                    @if(!isset($search_result->onbuy_product_info->id) && $status == 'publish')
                                        <div class="align-items-center mr-2"> <a class="btn-size list-onbuy-btn" href="{{url('onbuy/create-product/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                                    @endif
                                    <div class="align-items-center mr-2"><a class="btn-size add-product-btn" href="{{url('catalogue/'.$search_result->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fas fa-chart-bar" aria-hidden="true"></i></a></div>
                                    {{-- <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                    <div class="align-items-center" onclick="addTermsCatalog({{ $search_result->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                </div>
                                <div class="action-2">
                                    @if(!isset($search_result->woocommerce_catalogue_info->master_catalogue_id) && $status == 'publish')
                                        <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Woocommerce"><i class="fab fa-wordpress" aria-hidden="true"></i></a></div>
                                    @endif
                                    <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('shopify/catalogue/create/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Shopify"><i class="fab fa-shopify" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                    <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                    @if($status == 'publish')
                                        <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" href="{{url('create-ebay-product/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List on Ebay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                    @endif
                                    @if($status == 'draft')
                                        <div class="align-items-center mr-2">
                                            <form action="{{url('draft-make-complete')}}" method="post">
                                                @csrf
                                                <input  type="hidden" name="catalogue_id" value="{{$search_result->id ?? ''}}">
                                                <button class="publish-btn del-pub on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="align-items-center">
                                        <form action="{{route('product-draft.destroy',$search_result->id)}}" method="post" id="catalogueDelete{{$search_result->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <button href="#" class="delete-btn del-pub on-default remove-row" style="cursor: pointer" onclick="deleteConfirmationMessage('catalogue','catalogueDelete{{$search_result->id}}');" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End dropup content-->
                    </div>
                    <!--End manage button area-->

                    {{-- Add terms catalogue modal --}}
                    <div id="add-terms-catalog-modal-{{ $search_result->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                        <div class="cat-header add-terms-catalog-modal-header">
                            <div>
                                <label id="label_name" class="cat-label">Add terms to catalogue({{ $search_result->id }})</label>
                            </div>
                            <div class="cursor-pointer" onclick="trashClick(this)">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="cat-body add-terms-catalog-body">
                            <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                        <input type="text" class="form-control" name="product_draft_id" value="{{$search_result->id ? $search_result->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                    </div>
                                </div>

                                <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $search_result->id }}">
                                    <div class="col-md-10">
                                        <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                    </div>
                                </div>

                                <div class="form-group row pb-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn" style="margin-top:0px;">
                                            <b> Add </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{--End Add terms catalogue modal --}}

                </td>
            </tr>

            <!--hidden row -->
            <tr>
                <td  colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                    <div class="accordian-body collapse" id="demo{{$search_result->id}}">

                    </div>
                </td>
            </tr>
            <!--End hidden row -->


            <div class="modal fade" id="channelListing{{$search_result->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Channel Listing</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @isset($search_result->woocommerce_catalogue_info)
                                <div>
                                    <h5>Website </h5>
                                    <a href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$search_result->woocommerce_catalogue_info->id.'&action=edit'}}" class="btn btn-outline-secondary btn-sm ml-2" target="_blank">View On Website Admin</a>
                                </div>
                            @endisset
                            @if(isset($search_result->ebayCatalogueInfo[0]))
                                <div>
                                    <h5>eBay </h5>
                                    @foreach($search_result->ebayCatalogueInfo as $catalogueInfo)
                                        <div class="mb-2">
                                            <span>{{$catalogueInfo->AccountInfo->account_name ?? ''}}</span>
                                            <a href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" class="btn btn-outline-warning btn-xs ml-2" target="_blank">View On Ebay</a><br>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @isset($search_result->onbuy_product_info)
                                <div>
                                    <h5>OnBuy</h5>
                                    <a href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$search_result->onbuy_product_info->product_id.'/'}}" class="btn btn-outline-info btn-sm ml-2" target="_blank">View On Onbuy Admin</a>
                                </div>
                            @endisset
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        @else
            @if(isset($search_result->ProductVariations[0]->stock))
                <tr class="hide-after-complete-{{$search_result->id}}" id="mtr-{{$search_result->id}}" onclick="getVariation(this)">
                    @if($status == 'publish')
                        <td><input type="checkbox" name="catalgueCheckbox" class="catalogueCheckbox" value="{{$search_result->id}}"></td>
                    @endif
                    @if($status == 'draft')
                        <td><input type="checkbox" class="checkBoxClass" id="customCheck{{$search_result->id}}" value="{{$search_result->id}}"></td>
                    @endif
                    <td class="image" style="width: 10%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">

                        <!--Start each row loader-->
                        <div id="product_variation_loading{{$search_result->id}}" class="variation_load" style="display: none;"></div>
                        <!--End each row loader-->

                        @if(isset($search_result->single_image_info->image_url))
                            <a href="{{(filter_var($search_result->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$search_result->single_image_info->image_url : $search_result->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                <img src="{{(filter_var($search_result->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$search_result->single_image_info->image_url : $search_result->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image">
                            </a>
                        @else
                            <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                        @endif

                    </td>
    {{--                <td class="id" style="width: 10%; text-align: center !important; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->id}}</td>--}}
                    <td class="id" style="width: 10%; text-align: center !important;">
                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$search_result->id}}</span>
                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                        </div>
                    </td>
                    <td class="product-type" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                        <div style="text-align: center;">
                            @if($search_result->type == 'simple')
                                Simple
                            @else
                                Variation
                            @endif
                        </div>
                    </td>
                    <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                        <a href="https://www.topbrandoutlet.co.uk/wp-admin/post.php?post={{$search_result->id}}&action=edit" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit On Woocommerce">
                            {!! Str::limit(strip_tags($search_result->name),$limit = 100, $end = '...') !!}
                        </a>
                    </td>
                    <td class="category" style="cursor: pointer" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{json_decode($search_result)->woo_wms_category->category_name ?? ''}}</td>
                    <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$total_sold ?? 0}}</td>
                    <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->ProductVariations[0]->stock ?? 0}}</td>
                    <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">{{$search_result->product_variations_count ?? 0}}</td>
                    <td class="creator" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                        @if(isset($search_result->user_info->name))
                        <div class="wms-name-creator">
                            <div data-tip="on {{date('d-m-Y', strtotime($search_result->created_at))}}">
                                <strong class="@if($search_result->user_info->deleted_at) text-danger @else text-success @endif">{{$search_result->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="modifier" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$search_result->id}}" onclick="getVariation(this)" data-target="#demo{{$search_result->id}}" class="accordion-toggle">
                        @if(isset($search_result->modifier_info->name))
                            <div class="wms-name-modifier1">
                                <div data-tip=" on {{date('d-m-Y', strtotime($search_result->updated_at))}}">
                                    <strong class="@if($search_result->modifier_info->deleted_at) text-danger @else text-success @endif">{{$search_result->modifier_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @elseif(isset($search_result->user_info->name))
                            <div class="wms-name-modifier2">
                                <div data-tip="on {{date('d-m-Y', strtotime($search_result->created_at))}}">
                                    <strong class="@if($search_result->user_info->deleted_at) text-danger @else text-success @endif">{{$search_result->user_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="actions">
                        <!--start manage button area-->
                        <div class="btn-group dropup">
                            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Manage
                            </button>
                            <!--start dropup content-->
                            <div class="dropdown-menu">
                                <div class="dropup-content catalogue-dropup-content">
                                    <div class="action-1">
{{--                                        <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="ChannelFactory Listing"><a class="btn-size channel-listing-view" href="#" data-toggle="modal" target="_blank" data-target="#channelListing{{$search_result->id ?? ''}}"><i class="fa fa-ambulance" aria-hidden="true"></i></a></div>--}}
                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                        @if(!isset($search_result->onbuy_product_info->id))
                                            <div class="align-items-center mr-2"> <a class="btn-size list-onbuy-btn" href="{{url('onbuy/create-product/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fa fa-product-hunt" aria-hidden="true"></i></a></div>
                                        @endif
                                        <div class="align-items-center mr-2"><a class="btn-size add-product-btn" href="{{url('catalogue/'.$search_result->id.'/product')}}" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                        {{-- <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                        <div class="align-items-center" onclick="addTermsCatalog({{ $search_result->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                    </div>
                                    <div class="action-2">
                                        @if(!isset($search_result->woocommerce_catalogue_info->master_catalogue_id))
                                            {{-- <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Woocommerce"><i class="fa fa-wordpress" aria-hidden="true"></i></a></div> --}}
                                        @endif
                                        <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('shopify/catalogue/create/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Shopify"><i class="fab fa-shopify" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$search_result->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                        <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" href="{{url('create-ebay-product/'.$search_result->id)}}" data-toggle="tooltip" data-placement="top" title="List on Ebay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2">
                                            @if($status == 'draft')
                                                <form action="{{route('product-draft.publish',$search_result->id)}}" method="post">
                                                    @csrf
                                                    <button class="publish-btn del-pub on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="align-items-center mr-2">
                                            <form action="{{route('product-draft.destroy',$search_result->id)}}" method="post" id="catalogueDelete{{$search_result->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <button href="#" class="delete-btn del-pub on-default remove-row" style="cursor: pointer" onclick="deleteConfirmationMessage('catalogue','catalogueDelete{{$search_result->id}}');" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End dropup content-->
                        </div>
                        <!--End manage button area-->

                        {{-- Add terms catalogue modal --}}
                        <div id="add-terms-catalog-modal-{{ $search_result->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                            <div class="cat-header add-terms-catalog-modal-header">
                                <div>
                                    <label id="label_name" class="cat-label">Add terms to catalogue({{ $search_result->id }})</label>
                                </div>
                                <div class="cursor-pointer" onclick="trashClick(this)">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="cat-body add-terms-catalog-body">
                                <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                            <input type="text" class="form-control" name="product_draft_id" value="{{$search_result->id ? $search_result->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                        </div>
                                    </div>

                                    <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $search_result->id }}">
                                        <div class="col-md-10">
                                            <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                        </div>
                                    </div>

                                    <div class="form-group row pb-4">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn" style="margin-top:0px;">
                                                <b> Add </b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{--End Add terms catalogue modal --}}

                    </td>
                </tr>

                <!--hidden row -->
                <tr>
                    <td  colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                        <div class="accordian-body collapse" id="demo{{$search_result->id}}">

                        </div>
                    </td>
                </tr>
                <!--End hidden row -->



            @endif
        @endif

    @endforeach
    @endif

@elseif($status == 'ebay_pending')
    @if(isset($search_result))
        @foreach($search_result as $catalogue)
            <tr>
                <td class="image" style="width:6%; cursor: pointer; text-align: center" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">

                    <!--Start each row loader-->
                    <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                    <!--End each row loader-->

                    @isset($catalogue->single_image_info->image_url)
                        <a href="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                            <img src="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}" class="ebay-image zoom" alt="ebay-catalogue-image">
                        </a>
                    @endisset

                </td>
{{--                <td class="id" style="width: 6%; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">--}}
                <td class="id" style="width: 6%;">
                    <div class="id_tooltip_container d-flex justify-content-center align-items-start">
                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="product-type">
                    <div style="text-align: center;">
                        @if($catalogue->type == 'simple')
                             Simple
                        @else
                            Variation
                        @endif
                    </div>
                </td>
                <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                    <a class="ebay-product-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                        {{Str::limit($catalogue->name,100, $end = '...') }}
                    </a>
                </td>
                <?php
                $data = '';
                foreach ($catalogue->all_category as $category){
                    $data .= $category->category_name.',';
                }
                ?>
                <td class="category" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle"> {{rtrim($data,',')}} </td>
                {{--                                        <td class="text-justify">{{Str::limit(strip_tags($published_product-> description,10, $end = '...') }}</td>--}}
                {{--                                        <td>{{$published_product->regular_price}}</td>--}}
                {{--                                        <td>{{$published_product->sale_price}}</td>--}}
                {{--                                        <td>{{$published_product->low_quantity}}</td>--}}
                <td class="status text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>
                <td class="stock text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
                <td class="product text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
                <td class="creator" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                    @if(isset($catalogue->user_info->name))
                    <div class="wms-name-creator">
                        <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                            <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                        </div>
                    </div>
                    @endif
                </td>
                <td class="modifier" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                    @if(isset($catalogue->modifier_info->name))
                        <div class="wms-name-modifier1">
                            <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                <strong class="@if($catalogue->modifier_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->modifier_info->name ?? ''}}</strong>
                            </div>
                        </div>
                    @elseif(isset($catalogue->user_info->name))
                        <div class="wms-name-modifier2">
                            <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                    @endif
                </td>
                <td class="actions" style="width: 6%">

                    <div class="btn-group dropup">
                        <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropup-content catalogue-dropup-content">
                                <div class="action-1">
                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                    @if(!isset($catalogue->onbuy_product_info->id))
                                        <div class="align-items-center mr-2"> <a class="list-onbuy-btn btn-size" href="{{url('onbuy/create-product/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                                    @endif
                                    {{--                                                            <div class="align-items-center mr-2"><a class="btn-size catalogue-btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><img src="{{asset('assets/images/terms-catalogue.png')}}" alt="Add Terms To Catalogue" width="30" height="30" class="filter"></a></div>--}}
                                    {{-- <div class="align-items-center mr-2"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                    <div class="align-items-center" onclick="addTermsCatalog({{ $catalogue->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                    {{--                                                            <div class="align-items-center"><a class="btn-size invoice-btn invoice-btn-size" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><img src="{{asset('assets/images/receive-invoice.png')}}" alt="Receive Invoice" width="30" height="30" class="filter"></a></div>--}}
                                    <div class="align-items-center"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                </div>
                                <div class="action-2">
                                    <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$catalogue->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"><a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                    <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" target="_blank" href="{{url('create-ebay-product/'.$catalogue->id)}}" data-toggle="tooltip" data-placement="top" title="List on Ebay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                    @if($catalogue->status == 'draft')
                                        <div class="align-items-center mr-2">
                                            <form action="{{route('product-draft.publish',$catalogue->id)}}" method="post">
                                                @csrf
                                                <button class="del-pub btn-size publish-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="align-items-center">
                                        <form action="{{route('product-draft.destroy',$catalogue->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Add terms catalogue modal --}}
                    <div id="add-terms-catalog-modal-{{ $catalogue->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                        <div class="cat-header add-terms-catalog-modal-header">
                            <div>
                                <label id="label_name" class="cat-label">Add terms to catalogue({{ $catalogue->id }})</label>
                            </div>
                            <div class="cursor-pointer" onclick="trashClick(this)">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="cat-body add-terms-catalog-body">
                            <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                        <input type="text" class="form-control" name="product_draft_id" value="{{$catalogue->id ? $catalogue->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                    </div>
                                </div>

                                <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $catalogue->id }}">
                                    <div class="col-md-10">
                                        <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                    </div>
                                </div>

                                <div class="form-group row pb-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn" style="margin-top:0px;">
                                            <b> Add </b>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{--End Add terms catalogue modal --}}

                </td>
            </tr>


            <!--hidden row -->
            <tr>
                <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                    <div class="accordian-body collapse" id="demo{{$catalogue->id}}">

                    </div> <!-- end accordion body -->
                </td> <!-- hide expand td-->
            </tr> <!-- hide expand row-->



        @endforeach
    @endif
@elseif($status == 'onbuy_ean_pending')
    @if(isset($search_result))
        @foreach($search_result as $catalogue)
            @if(isset($catalogue->ProductVariations[0]->stock) && $catalogue->ProductVariations[0]->stock > 0)
                <tr>
                    <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">

                        <!--Start each row loader-->
                        <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                        <!--End each row loader-->

                        @isset($catalogue->single_image_info->image_url)
                            <a href="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                <img src="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}" class="onbuy-image zoom" alt="catalogue-image">
                            </a>
                        @endisset

                    </td>
{{--                    <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">--}}
                    <td class="id" style="width: 7%; text-align: center !important;">
                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                        </div>
                    </td>
                    <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        <a class="catalogue-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                            {!! Str::limit(strip_tags($catalogue->name),$limit = 100, $end = '...') !!}
                        </a>
                    </td>
                    <?php
                    $data = '';
                    foreach ($catalogue->all_category as $category){
                        $data .= $category->category_name.',';
                    }
                    ?>
                    <td class="category" style="text-align: center !important; cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle"> {{rtrim($data,',')}} </td>
                    <td class="status text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>
                    <td class="stock text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
                    <td class="product text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
                    <td class="creator" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        @if(isset($catalogue->user_info->name))
                        <div class="wms-name-creator">
                            <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                                <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="modifier" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        @if(isset($catalogue->modifier_info->name))
                            <div class="wms-name-modifier1">
                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                    <strong class="@if($catalogue->modifier_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->modifier_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @elseif(isset($catalogue->user_info->name))
                            <div class="wms-name-modifier2">
                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                    <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="actions" style="width: 6%;">

                        <div class="btn-group dropup">
                            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Manage
                            </button>
                            <div class="dropdown-menu">
                                <div class="dropup-content catalogue-dropup-content">
                                    <div class="action-1">
                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                        @if(!isset($catalogue->onbuy_product_info->id))
                                            <div class="align-items-center mr-2"> <a class="list-onbuy-btn btn-size" href="{{url('onbuy/create-product/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                                        @endif
                                        {{-- <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                        <div class="align-items-center" onclick="addTermsCatalog({{ $catalogue->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                    </div>
                                    <div class="action-2">
                                        <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                        <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$catalogue->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center mr-2"><a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                        <div class="align-items-center">
                                            <form action="{{route('product-draft.destroy',$catalogue->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Add terms catalogue modal --}}
                        <div id="add-terms-catalog-modal-{{ $catalogue->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                            <div class="cat-header add-terms-catalog-modal-header">
                                <div>
                                    <label id="label_name" class="cat-label">Add terms to catalogue({{ $catalogue->id }})</label>
                                </div>
                                <div class="cursor-pointer" onclick="trashClick(this)">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="cat-body add-terms-catalog-body">
                                <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                            <input type="text" class="form-control" name="product_draft_id" value="{{$catalogue->id ? $catalogue->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                        </div>
                                    </div>

                                    <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $catalogue->id }}">
                                        <div class="col-md-10">
                                            <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                        </div>
                                    </div>

                                    <div class="form-group row pb-4">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn" style="margin-top:0px;">
                                                <b> Add </b>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{--End Add terms catalogue modal --}}

                    </td>
                </tr>

                <!--hidden row -->
                <tr>
                    <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                        <div class="accordian-body collapse" id="demo{{$catalogue->id}}">

                        </div> <!-- end accordion body -->
                    </td> <!-- hide expand td-->
                </tr> <!-- hide expand row-->

            @endif
        @endforeach
    @endif
    @elseif($status == 'amazon_ean_pending')
    @if(isset($search_result))
        @foreach($search_result as $catalogue)
            @if(isset($catalogue->ProductVariations[0]->stock) && $catalogue->ProductVariations[0]->stock > 0)
                <tr>
                    <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">

                        <!--Start each row loader-->
                        <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                        <!--End each row loader-->

                        @isset($catalogue->single_image_info->image_url)
                            <a href="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                <img src="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}" class="amazon-image zoom" alt="catalogue-image">
                            </a>
                        @endisset

                    </td>
{{--                    <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">--}}
                    <td class="id" style="width: 7%; text-align: center !important;">
                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                        </div>
                    </td>
                    <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        <a class="catalogue-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                            {!! Str::limit(strip_tags($catalogue->name),$limit = 100, $end = '...') !!}
                        </a>
                    </td>
                    <?php
                    $data = '';
                    foreach ($catalogue->all_category as $category){
                        $data .= $category->category_name.',';
                    }
                    ?>
                    <td class="category" style="text-align: center !important; cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle"> {{rtrim($data,',')}} </td>
                    <td class="status text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>
                    <td class="stock text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
                    <td class="product text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
                    <td class="creator" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        @if(isset($catalogue->user_info->name))
                        <div class="wms-name-creator">
                            <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                                <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td class="modifier" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                        @if(isset($catalogue->modifier_info->name))
                            <div class="wms-name-modifier1">
                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                    <strong class="@if($catalogue->modifier_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->modifier_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @elseif(isset($catalogue->user_info->name))
                            <div class="wms-name-modifier2">
                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                    <strong class="@if($catalogue->user_info->deleted_at) text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="actions" style="width: 6%;">
                        <a href="{{url('amazon/create-amazon-product/'.$catalogue->id)}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="List On Amazon" target="_blank">
                            <i class="fa fa-amazon"></i>
                        </a>
                    </td>
                </tr>

                <!--hidden row -->
                <tr>
                    <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                        <div class="accordian-body collapse" id="demo{{$catalogue->id}}">

                        </div> <!-- end accordion body -->
                    </td> <!-- hide expand td-->
                </tr> <!-- hide expand row-->

            @endif
        @endforeach
    @endif

@elseif($status == 'woocom_pending')
    @if(isset($search_result))
        @foreach($search_result as $product_draft)
        <tr>
            <td class="image" style="width: 6%; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">

                <!--Start each row loader-->
                <div id="product_variation_loading{{$product_draft->id}}" class="variation_load" style="display: none;"></div>
                <!--End each row loader-->

                @if(isset($product_draft->single_image_info->image_url))
                    <a href="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                        <img src="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}" class="thumb-md zoom" alt="WooCommerce-image">
                    </a>
                @else
                    <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="WooCommerce-image">
                @endif

            </td>
{{--            <td class="id" style="width: 6%; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">--}}
            <td class="id" style="width: 6%; text-align: center !important;">
                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_draft->id}}</span>
                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="catalogue-name" style="width: 30%; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                <a class="catalogue-link" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">

                    {!! Str::limit(strip_tags($product_draft->name),$limit = 100, $end = '...') !!}

                </a>
            </td>
            <td class="category" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{json_decode($product_draft)->woo_wms_category->category_name ?? ''}}</td>
            <td class="rrp" style="width: 10%; cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{ $product_draft->rrp ?? ''}}</td>
            <td class="base_price" style="width: 10%; cursor: pointer; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_draft->base_price}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->base_price}}" class="accordion-toggle">{{ $product_draft->base_price ?? ''}}</td>
            @php
                $data = 0;
                if(count($product_draft->variations) > 0){
                    foreach ($product_draft->variations as $variation){
                        if(isset($variation->order_products[0]->sold)){
                            $data += $variation->order_products[0]->sold;
                        }
                    }
                }
            @endphp
            <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$data ?? 0}}</td>
            <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->ProductVariations[0]->stock ?? 0}}</td>
            <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->product_variations_count ?? 0}}</td>
            <td class="creator" style="width: 10% !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                @if(isset($product_draft->user_info->name))
                <div class="wms-name-creator">
                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                        <strong class="@if($product_draft->user_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                    </div>
                </div>
                @endif
            </td>
            <td class="modifier" style="width: 10% !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                @if(isset($product_draft->modifier_info->name))
                    <div class="wms-name-modifier1">
                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->updated_at))}}">
                            <strong class="@if($product_draft->modifier_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->modifier_info->name ?? ''}}</strong>
                        </div>
                    </div>
                @elseif(isset($product_draft->user_info->name))
                    <div class="wms-name-modifier2">
                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                            <strong class="@if($product_draft->user_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                        </div>
                    </div>
                @endif
            </td>
            <td class="actions draft-list" style="width: 6%">
                <div class="align-items-center">
                    <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On WooCommerce"><i class="fab fa-wordpress" aria-hidden="true"></i>
                    </a>
                </div>
            </td>
        </tr>


        <!--Hidden Row-->
        <tr>
            <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                <div class="accordian-body collapse"  id="demo{{$product_draft->id}}">

                </div> <!-- end accordion body -->
            </td> <!-- hide expand td-->
        </tr> <!-- hide expand row-->

    @endforeach
    @endif
@endif

<script>


    function getVariation(e){
        var product_draft_id = e.id;
        product_draft_id = product_draft_id.split('-');
        var id = product_draft_id[1]
        console.log(id);
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
                console.log(response);
                $('#demo'+id).html(response);
            },
            complete: function () {
                $('#product_variation_loading'+id).hide();
            }
        })
    }



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

    $(document).ready(function (){
        $(".checkBoxClass").change(function(){
            if (!$(this).prop("checked")){
                $("#ckbCheckAll").prop("checked",false);
            }
            var catalogueIds = catalogueIdArray();
        });
    });


    // Check uncheck active catalogue counter
    var ajaxPageCountCheckedAll = function() {
        var counter = $(".checkBoxClass:checked").length;
        @if($status == 'publish')
        $(".checkbox-count").html( counter + " active catalogue selected!" );
        console.log(counter + ' active catalogue selected!');
        @else
        $(".checkbox-count").html( counter + " draft product selected!" );
        console.log(counter + ' draft product selected!');
        @endif
    };

    $(".checkBoxClass").on( "click", ajaxPageCountCheckedAll );

    $('.ckbCheckAll').click(function (e) {
        $(this).closest('table').find('td .checkBoxClass').prop('checked', this.checked);
        ajaxPageCountCheckedAll();
    })

    $(document).ready(function() {
        $(".ckbCheckAll").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });
        $(".checkBoxClass").change(function(){
            if (!$(this).prop("checked")){
                $(".ckbCheckAll").prop("checked",false);
            }
        });
        $('.ckbCheckAll, .checkBoxClass').click(function () {
            if($('.ckbCheckAll:checked, .checkBoxClass:checked').length > 0) {
                $('div.active-catalogue-bulk-delete').show(500);
            }else{
                $('div.active-catalogue-bulk-delete').hide(500);
            }
        })
    });
    //End Check uncheck active catalogue counter

     //Modal button variation terms adding spining btn
     $('button.termsCatalogueBtn').click(function(){
        $(this).html(
            `<span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>Variation adding`
        );
        $(this).addClass('changeCatalogBTnCss');
    })


</script>
