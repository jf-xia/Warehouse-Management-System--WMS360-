

<style>
    .onoffswitch{
        /*margin-left: -6%;*/
        width: 70px;
    }
    .no-img-content{
        background-image: url('{{asset('assets/common-assets/no_image_box.jpg')}}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
</style>
<!-- <script>
  $( function() {

    $( ".sortable" ).sortable({
        cursor: 'move'

    });
    $( ".sortable" ).disableSelection();

  } );
  </script> -->

{{--<div class="form-group row">--}}
{{--    <label for="condition" class="col-md-2 col-form-label required">Ebay Account</label>--}}
{{--    <div class="col-md-10">--}}
{{--        <select id="account_id" class="form-control select2" name="account_id" >--}}
{{--            <option value="{{$result->account_id}}" selected>{{\App\EbayAccount::find($result->account_id)->account_name}}</option>--}}
{{--        </select>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="form-group row">--}}
{{--    <label for="condition" class="col-md-2 col-form-label required">Ebay Site</label>--}}
{{--    <div class="col-md-10">--}}
{{--        <select id="site_id" class="form-control select2" name="site_id">--}}
{{--            <option value="{{$result->site_id}}" selected>{{\App\EbaySites::find($result->site_id)->name}}</option>--}}
{{--        </select>--}}
{{--    </div>--}}
{{--</div>--}}



<div class="ebay-secondary-input-drawer-box" style="display: none">
    <div class="drawer-box-header">
        <div><i class="fa fa-close ebay-drawer-close-btn" onclick="ebayDrawerBoxCloseBtn()"></i></div>
        <div class="text-white">Listing Options</div>
    </div>
    <div class="drawer-box-body">
        <!--Condition-->
        <div class="form-group row">
            <div class="col-md-3 d-flex">
                <div>
                    <label for="condition_id" class="col-form-label required">Condition</label>
                </div>
                <div class="ml-1 mt-2">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">
                            Select the condition of the item you're listing.
                        </span>
                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            @isset($result->condition_id)
                <div class="col-md-9 pointer-events">
                    <!-- <div class="row d-flex justify-content-between"> -->
                        @if(isset($result->condition_id))
                            <!-- <div class="col-md-4 mb-3"> -->
                                <select name='condition_id' class="form-control select2" id="condition-select" readonly>
                                    <option value="{{$result->condition_id}}/{{$result->condition_name}}" selected readonly>{{$result->condition_name}}</option>
                                </select>
                            <!-- </div> -->
                        @else
                            condition not available
                        @endif
                    <!-- </div> -->
                </div>
            @endisset
        </div>
        <!--Category-->
        <div id="account_site_data">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row" id="all_category_div">
                        <div class="col-md-3 d-flex align-items-center">
                            <div>
                                <label for="Category" class="col-form-label required">Category</label>
                            </div>
                            <div class="ml-1">
                                <div id="wms-tooltip">
                                    <span id="wms-tooltip-text">Selecting the appropriate eBay category is important to appear under the right eBay category.</span>
                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 controls pointer-events" id="category-level-1-group">
                            <select class="form-control category_select select2 " name="child_cat[1]" id="child_cat_1" onchange="myFunction(1)">

                                <option value="">{{$result->category_name}}</option>

                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="category_name" value="{{$result->category_name}}">
                    <input type="hidden" name="account_id" id="account_id" value="{{$account_id}}">
                    <input type="hidden" name="site_id" id="site_id" value="{{$site_id}}">
                    {{-- <div class="form-group row">
                        <div class="col-md-2">   </div>
                        <div class="col-md-10">
                            <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                            <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                        </div>
                    </div> --}}
                </div>
                <div class="col-md-12">
                    {{--    second category--}}
                    <!--Sub Category-->

                    <div class="form-group row" id="all_category_div2">
                        <div class="col-md-3 d-flex align-items-center"><b class="sub-cat-font">Sub Category</b>
                            <div>
                                <label for="Category" class="col-md-2 col-form-label sub-label required"> </label>
                            </div>
                            <div class="sub-label">
                                <div id="wms-tooltip">
                                    <span id="wms-tooltip-text">Selecting a sub-category will make the listing appear in the second category.</span>
                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                </div>
                            </div>
                            <div class="create-ebay-close-btn" title="Click here to remove sub category" style="display: none">
                                <label class="fa fa-remove cursor-pointer" onclick="myFunction2(1,{{$profile_id}},'remove')"></label>
                            </div>
                        </div>
                        <input type="hidden" name="current_sub_category" value="{{$result->category_name}}">
                        <div class="" id="category2-level-0-group">

                        </div>
                        <div class="col-md-9 controls" id="category2-level-1-group">
                            <select class="form-control category2_select " name="child_cat2[1]" id="child_cat2_1" onchange="myFunction2(1,{{$profile_id}})">
                                <option value="">{{$result->sub_category_name}}</option>
                                @foreach($categories[0]['category'] as $category)
                                    <option value="{{$category['CategoryID']}}//{{$category["pivot"]['CategoryName']}}">{{$category["pivot"]['CategoryName']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="sub_category_name" value="{{$result->sub_category_name}}">
                     <div class="form-group row">
                        <div class="col-md-2">   </div>
                        <div class="col-md-10">
                            <button type="button" class="btn btn-primary m-t-10" id="list_button" style="display: none;">List</button>
                            <input type="text" class="form-control" name="last_cat_id" id="last_cat_id" style="display: none;" value="{{$result->category_id}}">
                            <input type="text" class="form-control" name="last_cat2_id" id="last_cat2_id" style="display: none;" value="{{$result->sub_category_id}}">
                        </div>
                    </div>
                </div>
            </div>



                        {{--    <div class="form-group row">--}}
                        {{--        <label for="country" class="col-md-2 col-form-label required">Country</label>--}}
                        {{--        <div class="col-md-10">--}}
                        {{--            <select class="form-control select2" name="country">--}}
                        {{--                <option value="">Select Country</option>--}}
                        {{--                @foreach($countries as $country)--}}
                        {{--                <option value="{{$country->country_code}}">{{$country->country_name}}</option>--}}
                        {{--                @endforeach--}}
                        {{--            </select>--}}
                        {{--        </div>--}}
                        {{--    </div>--}}

                        {{--    <div class="form-group row">--}}
                        {{--        <label for="location" class="col-md-2 col-form-label required">Location</label>--}}
                        {{--        <div class="col-md-10">--}}
                        {{--            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$result->location}}" maxlength="80" onkeyup="Count();" required autocomplete="location" autofocus>--}}
                        {{--            <span id="location" class="float-right"></span>--}}
                        {{--            @error('location')--}}
                        {{--            <span class="invalid-feedback" role="alert">--}}
                        {{--                <strong>{{ $message }}</strong>--}}
                        {{--            </span>--}}
                        {{--            @enderror--}}
                        {{--        </div>--}}
                        {{--    </div>--}}


                        {{--    <div class="form-group row">--}}
                        {{--        <label for="post_code" class="col-md-2 col-form-label required">Post code</label>--}}
                        {{--        <div class="col-md-10">--}}
                        {{--            <input id="post_code" type="text" class="form-control @error('post_code') is-invalid @enderror" name="post_code" value="{{$result->post_code}}" maxlength="80" onkeyup="Count();" required autocomplete="post_code" autofocus>--}}
                        {{--            <span id="post_code" class="float-right"></span>--}}
                        {{--            @error('post_code')--}}
                        {{--            <span class="invalid-feedback" role="alert">--}}
                        {{--                <strong>{{ $message }}</strong>--}}
                        {{--            </span>--}}
                        {{--            @enderror--}}
                        {{--        </div>--}}
                        {{--    </div>--}}
        </div>
        <!--Use Picture-->
        <div class="form-group row">
            <label for="condition" class="col-md-3 col-form-label required">Use Picture</label>
            <div class="col-md-9">
                <select class="form-control" name="eps" required>

                    @if($result->eps == 'EPS')
                        <option value="EPS" selected>EPS</option>
                    @elseif($result->eps =='Vendor')
                        <option value="Vendor" selected>Shelf Hosted</option>
                    @else
                        <option value="" disabled>Select Options</option>
                        <option value="EPS"  selected>EPS</option>
                        <option value="Vendor">Shelf Hosted</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-3 d-flex">
                <div>
                    <label for="private_listing" class="col-form-label">Private Listing</label>
                </div>
                <div class="">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">
                            Keep bidder and buyer identities hidden from other eBay members. <b>(fees may apply)</b>
                        </span>
                        <span><img class="wms-tooltip-image ml-1 mt-2" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-tabs profile-tab" role="tablist" id="privateTabList">
                    <li class="nav-item text-center privateListingContent_{{$profile_id}}">
                        <a class="nav-link active" data-toggle="tab" href="#privateTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})<label id="privateListing{{$profile_id}}"></label></a>
                    </li>
                </ul>
                <div class="container-fluid tab-content tab-content ebay-tab-content" id="privateListingDiv">
                    <div id="privateTab{{$profile_id}}" class="tab-pane active privateListingContent_{{$profile_id}}">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="private_listing[{{$profile_id}}]" value="1" class="custom-control-input private_listing" id="private_listing{{$profile_id}}">
                            <label class="custom-control-label" for="private_listing{{$profile_id}}"> </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div id="private_listing">
            <div class="form-group row"> <label for="condition" class="col-md-2 col-form-label">Private Listing ({{\App\EbayProfile::find($profile_id)->profile_name}})</label>
                <div class="col-md-10 wow pulse"><input type="checkbox" name="private_listing[{{$profile_id}}]" value="1"></div>
            </div>
        </div> --}}

        {{-- <div id="int_site_visibility"> --}}
            <div class="form-group row">
                <div class="col-md-3 d-flex">
                    <div>
                        <label for="condition_id" class="col-form-label">International Site Visibility</label>
                    </div>
                    <div class="ml-1 mt-2">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">Select an additional eBay site where you'd like this listing to appear. <b>(fees may apply)</b></span>
                            <span><img style="width: 18px; height: 18px;" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="internationalVisibilityTabList">
                        <li class="nav-item text-center interNationalSiteVisibility_{{$profile_id}}">
                            <a class="nav-link active" data-toggle="tab" href="#internationalVisibilityTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})<label id="intSiteVisibility{{$profile_id}}"></label></a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="internationalVisibilityDiv">
                        <div id="internationalVisibilityTab{{$profile_id}}" class="tab-pane active interNationalSiteVisibility_{{$profile_id}}">
                            <select name="cross_border_trade[{{$profile_id}}]" class="form-control" id="condition-select">
                                <option value="None" selected>-</option>
                                <option value="North America" >eBay US and Canada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}



        <!-- variation start-->

        @isset($product_result[0]['ProductVariations'])
            <div class="form-group row"> <!--Start Form group row-->

                    <div class="col-md-3 d-flex">
                        @if($product_result[0]->type == 'variable')
                            <div>
                                <label for="variation" class="col-form-label required">Variation</label>
                            </div>
                            <div>
                                <div id="wms-tooltip">
                                    <span id="wms-tooltip-text">This shows all the active variations related to this listing.</span>
                                    <span><img class="wms-tooltip-image mt-2 ml-1" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                </div>
                            </div>
                        @endif
                    </div>

                <div class="col-md-9">
                    @if($product_result[0]->type == 'variable')
                    <div class="variation-container card">
                        <input class="variation-collapse-open" type="checkbox" id="variation-collapse">
                        <label class="header card-header cursor-pointer variation-collapse-btn" for="variation-collapse">Expand Variation</label>
                    @endif
                        <div class="content">
                            @php
                                $no = 1;
                            @endphp
                            @foreach($product_result[0]['ProductVariations'] as  $key => $product_variation)

                                <div class="card mb-3 ebay-variation-card">
                                    <div>
                                        @if($product_result[0]->type == 'variable')
                                            {{-- <input class="collapse-open" type="checkbox" id="collapse-{{$no}}">
                                            <label class="collapse-btn" style="width: 100%;cursor: grab;" for="collapse-{{$no}}"> --}}
                                            <div class="card-header variation-header cursor-pointer" id="variation-header-{{$product_variation->id}}" onclick="variationDisplay({{$product_variation->id}})">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        {{ $no }}. &nbsp; [{{$product_variation->sku}}]
                                                        @if($product_result[0]->type == 'variable')
                                                            @isset($product_variation->attribute)
                                                                @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $key1 => $attribute)
                                                                    [{{$attribute["terms_name"]}}]
                                                                @endforeach
                                                            @endisset
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-arrow-down" id="fa-arrow-down-{{$product_variation->id}}"></i>
                                                        <i class="fas fa-arrow-up d-none" id="fa-arrow-up-{{$product_variation->id}}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- </label> --}}
                                            @if($product_result[0]->type == 'variable')
                                        {{-- <div class="collapse-painel"> --}}
                                        <div class="d-none" id="collapsePainel-{{$product_variation->id}}">
                                            <div class="collapse-inner">
                                                @endif
                                                <div class="wms-row">
                                                    <div class="wms-col-12">
                                                        <div class="variation_step_1">
                                                            <div class="wms-row">
                                                                <div class="wms-col-6">
                                                                    <div class="input-wrapper">
                                                                        <label class="variation-sku" for="sku">SKU</label>
                                                                        <input type="text" id="sku" data-parsley-maxlength="30" class="form-control variation-sku @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][sku]" value="{{$product_variation->sku}}" autocomplete="sku" autofocus>
                                                                        <input type="hidden" name="productVariation[{{$key}}][variation_id]" value="{{$product_variation->id}}">
                                                                        @error('sku')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                @if($product_result[0]->type == 'variable')
                                                                    @isset($product_variation->attribute)
                                                                        @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $key1 => $attribute)
                                                                            <div class="wms-col-6">
                                                                                <div class="input-wrapper">
                                                                                    <label class="variation-size" for="{{$attribute["attribute_name"]}}">{{$attribute["attribute_name"]}}</label>
                                                                                    <input type="text" id="{{$attribute["attribute_name"]}}" class="form-control variation-size @error($attribute["attribute_name"]) is-invalid @enderror" name="productVariation[{{$key}}][{{$attribute["attribute_name"]}}]" value="{{$attribute["terms_name"]}}" data-parsley-maxlength="30" autocomplete="{{$attribute["attribute_name"]}}" autofocus>
                                                                                    <input type="hidden" name="productVariation[{{$key}}][attribute][{{$key1}}][attribute_id]" value="{{$attribute["attribute_id"]}}">
                                                                                    <input type="hidden" name="productVariation[{{$key}}][attribute][{{$key1}}][attribute_name]" value="{{$attribute["attribute_name"]}}">
                                                                                    <input type="hidden" name="productVariation[{{$key}}][attribute][{{$key1}}][terms_id]" value="{{$attribute["terms_id"]}}">
                                                                                    <input type="hidden" name="productVariation[{{$key}}][attribute][{{$key1}}][terms_name]" value="{{$attribute["terms_name"]}}">
                                                                                    <input type="hidden" name="attribute[{{$attribute["attribute_name"]}}][]" value="{{$attribute["terms_name"]}}">
                                                                                    @if(isset($product_variation->image))
                                                                                        <input type="hidden" name="variation_image[{{$attribute["attribute_name"]}}][{{$attribute["terms_name"]}}][]" value="{{$product_variation->image}}">
                                                                                    @else
                                                                                        <input type="hidden" name="variation_image[{{$attribute["attribute_name"]}}][{{$attribute["terms_name"]}}][]" value="">
                                                                                    @endif
                                                                                    @error($attribute["attribute_name"])
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endisset
                                                                @endif

                                                                <div class="wms-col-6">
                                                                    <div class="input-wrapper">
                                                                        <label class="variation-start-price" for="start_price">Start Price</label>
                                                                        <input type="text" id="start_price" class="form-control variation-start-price @error('start_price') is-invalid @enderror" name="productVariation[{{$key}}][start_price]" value="{{$product_variation->sale_price}}" data-parsley-maxlength="30" autocomplete="start_price" autofocus>
                                                                        @error('start_price')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="wms-col-6">
                                                                    <div class="input-wrapper">
                                                                        <label class="variation-rrp" for="rrp">RRP</label>
                                                                        <input type="text" id="rrp" class="form-control variation-rrp @error('rrp') is-invalid @enderror" name="productVariation[{{$key}}][rrp]" value="{{$product_variation->regular_price}}" maxlength="80" onkeyup="Count();" required autocomplete="rrp" autofocus>
                                                                        <span id="rrp" class="float-right"></span>
                                                                        @error('rrp')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="wms-col-6">
                                                                    <div class="input-wrapper">
                                                                        <label class="variation-ean" for="ean">Enter EAN</label>
                                                                        <input type="text" id="ean" class="form-control variation-ean @error('ean') is-invalid @enderror" name="productVariation[{{$key}}][ean]" value="{{$product_variation->ean_no}}" data-parsley-maxlength="30" autocomplete="ean" autofocus>

                                                                        @error('ean')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="wms-col-6">
                                                                    <div class="input-wrapper">
                                                                        <label class="variation-quantity" for="quantity">Enter Quantity</label>
                                                                        <input type="text" id="quantity" class="form-control variation-quantity @error('quantity') is-invalid @enderror" name="productVariation[{{$key}}][quantity]" value="{{$product_variation->actual_quantity}}" data-parsley-maxlength="30" autocomplete="quantity" autofocus>
                                                                        @error('quantity')
                                                                        <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--End wms-col-8-->
                                                    @if($product_result[0]->type == 'variable')
                                                        <div class="wms-col-12">
                                                            <div class="variation_step_2">
                                                                <div class="variation-image-header">
                                                                    IMAGE
                                                                </div>
                                                                <div class="variation-image-body">
                                                                    @if($product_variation->image != null)
                                                                        <input type="hidden" id="image" name="productVariation[{{$key}}][image]" value="{{$product_variation->image}}">
                                                                        <img src="{{$product_variation->image}}">
                                                                    @else
                                                                        <input type="hidden" id="image" name="productVariation[{{$key}}][image]" value="{{$product_result[0]['images'][0] ?? ''}}">
                                                                        <img src="{{asset('uploads/no_image.jpg')}}">
                                                                    @endif
                                                                    @error('image')
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div><!--End wms-col-4-->
                                                    @endif

                                                </div><!--End wms row-->
                                                @if($product_result[0]->type == 'variable')
                                            </div><!--End collapse-inner-->
                                        </div><!--End collapse-painel-->
                                            @endif
                                    </div> <!--End empty div-->
                                </div> <!--End card-->
                            @php
                                $no++;
                            @endphp
                        @endforeach


                        </div><!--End Content-->
                        @if($product_result[0]->type == 'variable')
                    </div><!--End variation container-->
                    @endif
                </div> <!--End col-md-10 -->
            </div> <!--End form group row-->
        @endisset


    <!-- End  variation   -->

    </div>
</div>


    {{-- Title div --}}
    {{-- <div id="title_div"> --}}
        <div class="form-group row" id="t{{$profile_id}}">
            <div class="col-md-2 d-flex">
                <div>
                    <label for="title_flag" class="col-form-label required">Title</label>
                </div>
                <div class="list-on-ebay-title">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text" class="create-ebay-title-text">
                            A descriptive title helps buyers find your item. State exactly what your item is. Include words that buyers might use to search for your item.
                        </span>
                        <span><img class="wms-tooltip-image ml-1 mt-2" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-1">
                <div class="onoffswitch mb-sm-10">
                    <input type="checkbox" value="1" name="title_flag[{{$profile_id}}]" class="onoffswitch-checkbox"  id="title_flag{{$profile_id}}" tabindex="1" checked>
                    <label class="onoffswitch-label" for="catalogue-name">
                        <span onclick="onOff('title_flag{{$profile_id}}')" class="onoffswitch-inner"></span>
                        <span onclick="onOff('title_flag{{$profile_id}}')" class="ebay-onoffswitch-switch"></span>
                    </label>
                </div>
            </div> --}}
            <div class="col-md-10">
                <ul class="nav nav-tabs profile-tab" role="tablist" id="titleTabList">
                    <li class="nav-item text-center titleContent_{{$profile_id}}">
                        <a class="nav-link active" data-toggle="tab" href="#titleTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})</a>
                    </li>
                </ul>
                <div class="container-fluid tab-content tab-content ebay-tab-content" id="title_div">
                    <div id="titleTab{{$profile_id}}" class="tab-pane active titleContent_{{$profile_id}}">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="onoffswitch my-3 mb-sm-10">
                                    <input type="checkbox" value="1" name="title_flag[{{$profile_id}}]" class="onoffswitch-checkbox"  id="title_flag{{$profile_id}}" tabindex="1" checked>
                                    <label class="onoffswitch-label" for="catalogue-name">
                                        <span onclick="onOff('title_flag{{$profile_id}}')" class="onoffswitch-inner"></span>
                                        <span onclick="onOff('title_flag{{$profile_id}}')" class="ebay-onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="ml-3 my-3 ebay-title-res">
                                    <input id="name{{$profile_id}}" type="text" class="form-control @error('name') is-invalid @enderror" name="name[{{$profile_id}}]" value="{{$product_result[0]->name}}" maxlength="80" onkeyup="Count('name{{$profile_id}}','display{{$profile_id}}');" oninput="autoOff('title_flag{{$profile_id}}',{{$profile_id}});" required autocomplete="name" autofocus>
                                    <span id="display{{$profile_id}}" class="float-right"></span>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}



    {{-- subtitle_div --}}
        <div class="form-group row" id="sub{{$profile_id}}">
            <div class="col-md-2 d-flex">
                <div>
                    <label for="name"  class="col-form-label">Subtitle</label>
                </div>
                <div class="list-on-ebay-title">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">
                            Subtitles appear in eBay search results in list view and can increase buyer interest by providing more descriptive info. <b>(fees may apply)</b>
                        </span>
                        <span><img class="wms-tooltip-image mt-2 ml-1" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>

    {{--        <div class="col-md-1">--}}
    {{--            <div class="onoffswitch">--}}
    {{--                <input type="checkbox" value="1" name="title_flag[{{$profile_id}}]" class="onoffswitch-checkbox"  id="title_flag{{$profile_id}}" tabindex="1" checked>--}}
    {{--                <label class="onoffswitch-label" for="catalogue-name">--}}
    {{--                    <span onclick="onOff('title_flag{{$profile_id}}')" class="onoffswitch-inner"></span>--}}
    {{--                    <span onclick="onOff('title_flag{{$profile_id}}')" class="onoffswitch-switch"></span>--}}
    {{--                </label>--}}
    {{--            </div>--}}
    {{--        </div>--}}
            <div class="col-md-10">
                <ul class="nav nav-tabs profile-tab" role="tablist" id="subTitleTabList">
                    <li class="nav-item text-center subTitleContent_{{$profile_id}}">
                        <a class="nav-link active" data-toggle="tab" href="#subTitleTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}}) <label id="subl{{$profile_id}}"></label></a>
                    </li>
                </ul>
                <div class="container-fluid tab-content tab-content ebay-tab-content" id="subtitle_div">
                    <div id="subTitleTab{{$profile_id}}" class="tab-pane active subTitleContent_{{$profile_id}}">
                        <input id="subtitle{{$profile_id}}" type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle[{{$profile_id}}]" value="" maxlength="80" autocomplete="name" autofocus>
                        <span id="display{{$profile_id}}" class="float-right"></span>
                        @error('subtitle')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}



            <div class="form-group row" id="fq{{$profile_id}}">
                <div class="col-md-2 d-flex">
                    <div>
                        <label for="custom_feeder_flag" class="col-form-label required">Feeder Quantity</label>
                    </div>
                    <div>
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">A feeder quantity will free up your monthly selling allowance & allow you to list more over loading your current allowance. Please set the max quantity limit that should be shown on eBay at a given time. Upon sales WMS360 will feed up to max limit set by you.</span>
                            <span><img class="wms-tooltip-image mt-2 ml-1" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="quantityTabList">
                        <li class="nav-item text-center feederQtyContent_{{$profile_id}}">
                            <a class="nav-link active" data-toggle="tab" href="#feederQuantityTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})</a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="quantity_div">
                        <div id="feederQuantityTab{{$profile_id}}" class="tab-pane active feederQtyContent_{{$profile_id}}">
                            <div class="feederQtyDivInner">
                                <div class="onoffswitch my-3 mb-sm-10">
                                    <input type="checkbox" value="1" name="custom_feeder_flag[{{$profile_id}}]" class="onoffswitch-checkbox"  id="custom_feeder_flag{{$profile_id}}" tabindex="1" checked>
                                    <label class="onoffswitch-label" for="catalogue-name">
                                        <span onclick="onOff('custom_feeder_flag{{$profile_id}}')" class="onoffswitch-inner"></span>
                                        <span onclick="onOff('custom_feeder_flag{{$profile_id}}')" class="ebay-onoffswitch-switch"></span>
                                    </label>
                                </div>
                                <div class="ml-3 my-3 ebay-qty-input">
                                    <!-- <input id="custom_feeder_quantity{{$profile_id}}" type="number" class="form-control @error('feeder_quantity') is-invalid @enderror" name="custom_feeder_quantity[{{$profile_id}}]" min="3"  value="{{$feeder_quantity ?? 3}}" maxlength="80" oninput="autoOff('custom_feeder_flag{{$profile_id}}',{{$profile_id}});" required autocomplete="custom_feeder_quantity" autofocus> -->
                                    <input id="custom_feeder_quantity{{$profile_id}}" type="number" class="form-control @error('feeder_quantity') is-invalid @enderror" name="custom_feeder_quantity[{{$profile_id}}]" value="{{$feeder_quantity ?? 0}}" maxlength="80" oninput="feederQuantity({{$profile_id}});" required autocomplete="custom_feeder_quantity" autofocus>
                                    <span id="custom_feeder_quantity{{$profile_id}}" class="float-right"></span>
                                    @error('custom_feeder_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->



    {{--<iframe>--}}
    {{--    {!! $template_result !!}--}}
    {{--</iframe>--}}




    {{--<input type="hidden" name="template_id" value="{{$template_id}}">--}}
    <input type="hidden" name="product_id" value="{{$id}}">
    {{--<a class="btn btn-default my-4" target="_blank" href="{{URL::to('check-template').'/'.$template_id.'/'.$id}}">Check Template</a>--}}

    <!--variation image upload-->
        <span class="{{$profile_id}}">
            <div class="form-group row" id="i{{$profile_id}}">
                <div class="col-md-2 d-flex">
                    <div>
                        <label for="ean" class="col-form-label">Master product image</label>
                    </div>
                    <div class="ml-1 mt-1 mt-sm-2">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">The right picture is the key to convert your visitor into a customer. Photos need to be at least 500 pixels on the longest side but we recommend you aim for 800-1600 pixels on the longest side.</span>
                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="imgTablist">
                        <li class="nav-item text-center imgContent_{{$profile_id}}">
                            <a class="nav-link active" data-toggle="tab" href="#ebay_multiple_pro_up{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})<span id="default_counter{{$profile_id}}"></span></a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="image_div">
                        <div id="ebay_multiple_pro_up{{$profile_id}}" class="tab-pane active imgContent_{{$profile_id}}">
                            <div class="d-flex mb-3">
                                <div class="onoffswitch mb-sm-10">
                                    <input type="checkbox" value="1" name="image_flag[{{$profile_id}}]" class="onoffswitch-checkbox" id="image_flag{{$profile_id}}" tabindex="1" checked>
                                    <label class="onoffswitch-label" for="catalogue-name[{{$profile_id}}]">
                                        <span onclick="onOff('image_flag{{$profile_id}}')" class="onoffswitch-inner"></span>
                                        <span onclick="onOff('image_flag{{$profile_id}}')" class="ebay-onoffswitch-switch"></span>
                                    </label>
                                </div>
                                <div id="counter{{$profile_id}}" class="mt-2 ml-2"></div>
                            </div>

                            <div class="row pl-2 ebay-glsm">
                                <div class="col-md-6 main-lf-image-content">
                                    <div class="main_image_show" id="main-lf-image-content_{{$profile_id}}">
                                        <span class="prev hide">Prev</span>
                                        <div class="md-trigger hide" data-modal="modal-12">Click to enlarge</div>
                                        <div class="showimagediv create-ebay-showimagediv" id="showimagediv{{$profile_id}}"></div>
                                        <span class="next hide">Next</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 master-pro-img" style="padding:0;" id="imageProId_{{$profile_id}}">
                                    <ul class="d-flex flex-wrap sortable ebay-image-wrap create-ebay-image-wrap" id="sortableImageDiv{{$profile_id}}">
                                        @if(isset($ebayEndProduct) && ($ebayEndProduct == true))
                                            @if(isset($ebayMasterImages))
                                                @php
                                                    $counter = 0;
                                                @endphp
                                                @foreach($ebayMasterImages as $images)
                                                    <li class="drag-drop-image create-ebay active" id="drag-drop-image{{$profile_id}}">
                                                        <a class="cross-icon bg-white border-0 btn-outline-light" id="{{$images ?? ''}}" onclick="removeLi(this)">&#10060;</a>
                                                        <input type="hidden" id="image" name="newUploadImage[{{$profile_id}}][]" value="{{$images}}">
                                                        <span class="main_photo"></span>
                                                        <img class="create_drag_drop_image" id="drag_drop_image{{$profile_id}}" src="{{$images}}">
                                                        <p class="drag_and_drop hide" id="drag_and_drop_{{$profile_id}}"></p>
                                                    </li>
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                @endforeach
                                                @for($i=0; $i< 12-$counter; $i++)
                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$profile_id}}">
                                                    <p class="inner-add-sign" id="innerAddSign{{$profile_id}}">&#43;</p>
                                                    <input type="file" title=" " name="uploadImage[{{$profile_id}}][]" id="uploadImage{{$profile_id}}" class="form-control create-ebay-img-upload" accept="/image" onchange="preview_image({{$profile_id}});" multiple disabled>
                                                    <p class="inner-add-photo" id="innerAddPhoto{{$profile_id}}">Add Photos</p>
                                                </div>
                                                @endfor
                                            @endif
                                        @else
                                            @if(isset($product_result[0]['images']))
                                                @php
                                                    $counter = 0;
                                                @endphp
                                                @foreach($product_result[0]['images'] as $images)
                                                    <li class="drag-drop-image active" id="drag-drop-image{{$profile_id}}">
                                                        <a class="cross-icon bg-white border-0 btn-outline-light" id="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}" onclick="removeLi(this)">&#10060;</a>
                                                        <input type="hidden" id="image" name="newUploadImage[{{$profile_id}}][]" value="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                                        <span class="main_photo"></span>
                                                        <img class="create_drag_drop_image" id="drag_drop_image{{$profile_id}}" src="{{(filter_var($images->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$images->image_url : $images->image_url}}">
                                                        <p class="drag_and_drop hide" id="drag_and_drop_{{$profile_id}}"></p>
                                                    </li>
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                @endforeach
                                                @for($i=0; $i< 12-$counter; $i++)
                                                <div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent{{$profile_id}}">
                                                    <p class="inner-add-sign" id="innerAddSign{{$profile_id}}">&#43;</p>
                                                    <input type="file" title=" " name="uploadImage[{{$profile_id}}][]" id="uploadImage{{$profile_id}}" class="form-control create-ebay-img-upload" accept="/image" onchange="preview_image({{$profile_id}});" multiple disabled>
                                                    <p class="inner-add-photo" id="innerAddPhoto{{$profile_id}}">Add Photos</p>
                                                </div>
                                                @endfor
                                            @endif
                                        @endif
                                    </ul>

                                </div>
                            </div>
                            @error('ean')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="custom-control custom-checkbox d-flex align-items-center">
                                        <input type="checkbox" class="custom-control-input galleryPlus" name="galleryPlus[{{$profile_id}}]" value="1" id="galleryPlus-{{$profile_id}}" @if($result->galleryPlus) checked @endif>
                                        <strong>  Display a large photo in search results with Gallery Plus <span id="productImg{{$profile_id}}"></span> <span id="imgfees{{$profile_id}}">(fees may apply)</span></strong>
                                        <label class="custom-control-label" for="galleryPlus-{{$profile_id}}"> </label>
                                    </div>
                                    {{-- <input type="checkbox" name="galleryPlus[{{$profile_id}}]" onclick="verify({{$profile_id}})" value="1" @if($result->galleryPlus) checked @endif>
                                    <strong>  Display a large photo in search results with Gallery Plus (fees may apply)</strong> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </span>



    <!-- Master product image preview fullscreen modal-->
    <div class="md-modal md-effect-12">
        <div class="md-modal-content">
            <div style="color: #fff;font-size: 20px;margin-bottom: 10px;margin-left: 10px;" id="modal_counter{{$profile_id}}"></div>
            <span class="previous before">Prev</span>
                <div class="md-content">
                    <div>
                        <span class="md-close float-right text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="showimagediv" id="showimagediv{{$profile_id}}"></div>

                        </div>
                    </div>
                </div>
            <span class="then after">Next</span>
        </div>
    </div>
    <div class="md-overlay"></div>
    <!--End master product image preview fullscreen -->


    <!--Description-->
    <div class="form-group row" id="d{{$profile_id}}">
        <div class="col-md-2 d-flex">
            <div>
                <label for="description" class="col-form-label required">Description</label>
            </div>
            <div style="margin-left: 5px !important" class="ml-1 ml-sm-0">
                <div id="wms-tooltip">
                    <span id="wms-tooltip-text">
                        Describe the item you're selling and provide complete and accurate details. Use a clear and concise format to ensure your description is mobile-friendly.
                    </span>
                    <span><img class="wms-tooltip-image mt-2" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="ebay-description-container card">
                <input class="ebay-description-collapse-open" type="checkbox" id="ebay-description-collapse">
                <label class="ebay-description-header card-header cursor-pointer ebay-description-collapse-btn" for="ebay-description-collapse">Expand Description</label>
                <div class="ebay-description-content" style="display: none;">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="desTablist">
                        <li class="nav-item text-center desContent_{{$profile_id}}">
                            <a class="nav-link active" data-toggle="tab" href="#descriptionTab{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})</a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="description_div">
                        <div id="descriptionTab{{$profile_id}}" class="tab-pane description-tab active desContent_{{$profile_id}}">
                            <div class="onoffswitch mb-3 mb-sm-10">
                                <input type="checkbox" value="1" name="description_flag[{{$profile_id}}]" class="onoffswitch-checkbox" id="description_flag{{$profile_id}}" tabindex="1" checked>
                                <label class="onoffswitch-label" for="description_flag">
                                    <span onclick="onOff('description_flag{{$profile_id}}')" class="onoffswitch-inner"></span>
                                    <span onclick="onOff('description_flag{{$profile_id}}')" class="ebay-onoffswitch-switch"></span>
                                </label>
                            </div>
                            <textarea id="messageArea{{$profile_id}}"  name="description[{{$profile_id}}]" rows="10" cols="30" oninput="autoOff('description_flag{{$profile_id}}',{{$profile_id}});" required autofocus>{{$product_result[0]->description}}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Item Specifies-->
    <div id="add_variant_product">

        <div class="form-group row">
            <div class="col-md-2 d-flex">
                <div>
                    <label for="modelslist" class="col-form-label required">Item Specifies</label>
                </div>
                <div class="ml-1 mt-1 mt-sm-2">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">
                            Provide info about the item you're selling, such as brand, size type, size, colour and style. These details help buyers find your item when they filter their searches and appear at the top of your listing description in a consistent format.
                        </span>
                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-10">


                <div class="col-md-12">
                    {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
                </div>


                <div class="row d-flex justify-content-between">
                    @foreach($item_specific_results as $key => $value)
                        <div class="col-md-3 mb-3">
                            <label style="font-weight: normal">{{$key}}

                            </label>
                            <input type="text" class="form-control"  name='item_specific[{{$key}}]' value="{{$value}}">
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
        </div>

            <!--Shop Category-->
            @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
            <div class="form-group row" id="sp{{$profile_id}}">
                <div class="col-md-2 d-flex">
                    <div>
                        <label for="store_id" class="col-form-label custom-col-form-lebel">Shop Category</label>
                    </div>
                    <div class="ml-1">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">
                                If you have an eBay Shop, select the Shop categories of the items you're listing.
                            </span>
                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="shopCatTablist">
                        <li class="nav-item text-center shopCategoryContent_{{$profile_id}}">
                            <a class="nav-link active" data-toggle="tab" href="#shopCatTabId{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})</a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="shopCatTab">
                        <div id="shopCatTabId{{$profile_id}}" class="tab-pane active shopCategoryContent_{{$profile_id}}">
                            <div class="row">
                                <div class="col-md-2 d-flex align-items-center">
                                    Shop Category 1
                                </div>
                                <div class="col-md-10">
                                    <select name='store_id[{{$profile_id}}]' class="form-control select2">
                                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category))
                                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                @if(isset($child_category_2['CategoryID']))
                                                                    @if($result->store_id == $child_category_2['CategoryID'])
                                                                        <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                    @else
                                                                        <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @if($result->store_id == $child_category_1['CategoryID'])
                                                                <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                            @else
                                                                <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($result->store_id == $shop_category['CategoryID'])
                                                        <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}" selected>{{$shop_category['Name']}}</option>
                                                    @else
                                                        <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-2 d-flex align-items-center">
                                    Shop Category 2
                                </div>
                                <div class="col-md-10">
                                    <select name='store2_id[{{$profile_id}}]' class="form-control select2">
                                        @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                            @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                                @if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory']))
                                                    @foreach($shop_category['ChildCategory'] as $child_category_1)
                                                        @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                            @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                                @if(isset($child_category_2['CategoryID']))
                                                                    @if($result->store2_id == $child_category_2['CategoryID'])
                                                                        <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                    @else
                                                                        <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @if($result->store2_id == $child_category_1['CategoryID'])
                                                                <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                            @else
                                                                <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['CategoryID']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($result->store2_id == $shop_category['CategoryID'])
                                                        <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}" selected>{{$shop_category['Name']}}</option>
                                                    @else
                                                        <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endisset

            <!--Shop Category 2 -->
            {{-- @isset($shop_categories['Store']['CustomCategories']['CustomCategory'])
            <div class="form-group row" id="sp{{$profile_id}}">
                <div class="col-md-2 d-flex">
                    <div>
                        <label for="store2_id" class="col-form-label custom-col-form-lebel">Shop Category 2</label>
                    </div>
                    <div class="ml-1">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">
                                If you have an eBay Shop, select the Shop categories of the items you're listing.
                            </span>
                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <ul class="nav nav-tabs profile-tab" role="tablist" id="shopCatTablist_2">
                        <li class="nav-item text-center">
                            <a class="nav-link active" data-toggle="tab" href="#shopCatTabId_2{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})</a>
                        </li>
                    </ul>
                    <div class="container-fluid tab-content tab-content ebay-tab-content" id="shopCatTab_2">
                        <div id="shopCatTabId_2{{$profile_id}}" class="tab-pane active">
                            <select name='store2_id[{{$profile_id}}]' class="form-control select2">
                            @if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory']))
                                @foreach($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category)
                                    @if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory']))
                                        @foreach($shop_category['ChildCategory'] as $child_category_1)
                                            @if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory']))
                                                @foreach($child_category_1['ChildCategory'] as $child_category_2)
                                                    @if(isset($child_category_2['CategoryID']))
                                                        @if($result->store2_id == $child_category_2['CategoryID'])
                                                            <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                        @else
                                                            <option value="{{$child_category_2['CategoryID']}}/{{$child_category_2['Name']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}>{{$child_category_2['Name']}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @else
                                                @if($result->store2_id == $child_category_1['CategoryID'])
                                                    <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['Name']}}" selected>{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                @else
                                                    <option value="{{$child_category_1['CategoryID']}}/{{$child_category_1['CategoryID']}}">{{$shop_category['Name']}}>{{$child_category_1['Name']}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        @if($result->store2_id == $shop_category['CategoryID'])
                                            <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}" selected>{{$shop_category['Name']}}</option>
                                        @else
                                            <option value="{{$shop_category['CategoryID']}}/{{$shop_category['Name']}}">{{$shop_category['Name']}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <option value="{{$shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']}}/{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}">{{$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']}}</option>
                            @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @endisset --}}





        <!--Condition Description-->
        <div class="form-group row" id="condition-description-sec">
            <div class="col-md-2 d-flex align-items-center">
                <div>
                    <label for="condition_description" class="col-form-label">Condition Description</label>
                </div>
                <div class="ml-1">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                        <span><img style="width: 18px; height: 18px;" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <textarea rows="1" style="width: 100%;" class="form-control profile-data" name="condition_description">{{$result->condition_description}}</textarea>
            </div>
        </div>
    </div>

    {{--<div class="form-group row">--}}
    {{--    <label for="condition" class="col-md-2 col-form-label required">Duration</label>--}}
    {{--    <div class="col-md-10">--}}
    {{--        <select class="form-control select2" name="duration">--}}
    {{--            <option value="{{$result->duration}}">{{$result->duration}}</option>--}}
    {{--        </select>--}}
    {{--    </div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--    <label for="condition" class="col-md-2 col-form-label">Pypal Account</label>--}}
    {{--    <div class="col-md-10">--}}
    {{--        <select class="form-control select2" name="paypal">--}}
    {{--            <option value="{{$result->paypal}}" selected>{{$result->paypal}}</option>--}}
    {{--        </select>--}}
    {{--    </div>--}}
    {{--</div>--}}

    @if($product_result[0]->type == 'simple')
    <div class="form-group row">
        <div class="col-md-2 d-flex align-items-center">
            <div>
                <label for="start_price" class="col-form-label required">Start Price in <strong>{{$result->currency}}</label>
            </div>
            <div class="ml-1">
                <div id="wms-tooltip">
                    <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                    <span><img style="width: 18px; height: 18px;" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                </div>
            </div>
        </div>
        <input type="hidden" name="currency" value="{{$result->currency}}">
        <div class="col-md-10">
            <input id="start_price" type="text" class="form-control @error('start_price') is-invalid @enderror" name="start_price" value="{{$product_result[0]->sale_price}}" maxlength="80" required autocomplete="start_price" autofocus>
            <span id="start_price" class="float-right"></span>
            @error('start_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    @endif


    {{--<div class="form-group row">--}}
    {{--    <label for="shipment_id" class="col-md-2 col-form-label required">Return Policy</label>--}}
    {{--    <div class="col-md-10">--}}
    {{--        <select class="form-control select2" name="return_id">--}}
    {{--            <option value="{{$result->return_id}}" selected>{{\App\ReturnPolicy::select('return_name')->where('return_id',$result->return_id)->get()->first()['return_name']}}</option>--}}
    {{--        </select>--}}
    {{--    </div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--    <label for="shipment_id" class="col-md-2 col-form-label required">Shipment Policy</label>--}}
    {{--    <div class="col-md-10">--}}
    {{--        <select class="form-control select2" name="shipping_id">--}}
    {{--            <option value="{{$result->shipping_id}}" selected>{{\App\ShipmentPolicy::select('shipment_name')->where('shipment_id',$result->shipping_id)->get()->first()['shipment_name']}}</option>--}}
    {{--        </select>--}}
    {{--    </div>--}}
    {{--</div>--}}

    {{--<div class="form-group row">--}}
    {{--    <label for="payment_id" class="col-md-2 col-form-label required">Currency</label>--}}
    {{--    <div class="col-md-10">--}}
    {{--        <select class="form-control select2" name="currency" required>--}}
    {{--            <option value="" >Select Currency</option>--}}
    {{--            @foreach($currency as $currency_info)--}}
    {{--                <option value="{{$currency_info->currency}}" >{{$currency_info->currency}}</option>--}}
    {{--            @endforeach--}}

    {{--        </select>--}}
    {{--    </div>--}}
    {{--</div>--}}

    @if($product_result[0]->type == 'variable')
            @if(isset($product_result[0]['ProductVariations'][0]['image_attribute']))
            <div class="form-group row" style="display: none">
                <div class="col-md-2 d-flex align-items-center">
                    <div>
                        <label for="image_attribute" class="col-form-label required">Image Variation</label>
                    </div>
                    <div class="ml-1">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 wow pulse">
                    <select class="form-control select2" name="image_attribute">
                        @foreach(unserialize($product_result[0]['ProductVariations'][0]['image_attribute']) as $key => $value)
                            <option value="{{$key}}" selected>{{$key}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        @else
            <div class="form-group row" style="display: none">
                <div class="col-md-2 d-flex align-items-center">
                    <div>
                        <label for="image_attribute" class="col-form-label required">Image Variation</label>
                    </div>
                    <div class="ml-1">
                        <div id="wms-tooltip">
                            <span id="wms-tooltip-text">Tooltips are labels that appear on hover and focus when</span>
                            <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 wow pulse">
                    <select class="form-control select2" name="image_attribute">
                        <option value="">Select Image Variation</option>
                        @if(count(\Opis\Closure\unserialize($product_result[0]['ProductVariations'][0]->attribute)) == 0)
                            @foreach(\Opis\Closure\unserialize($product_result[0]['ProductVariations'][0]->attribute) as $attribute)
                                <option value="{{$attribute["attribute_name"]}}">{{$attribute["attribute_name"]}}</option>
                            @endforeach
                        @else
                            @foreach(\Opis\Closure\unserialize($product_result[0]['ProductVariations'][0]->attribute) as $attribute)
                                <option value="{{$attribute["attribute_name"]}}" selected>{{$attribute["attribute_name"]}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        @endif
    @endif

    {{--    <h1 class="title">Checkout</h1>--}}
    {{--    <p class="price" data-price="21">$21 per month</p>--}}
    {{--    <p class="description">Quantity:</p>--}}
    {{--    <button type="button" class="decrease-btn">-</button>--}}
    {{--    <input type="text" class="quantity" value="1">--}}
    {{--    <button type="button" class="increase-btn">+</button>--}}
    {{--    <p class="total">Total: <span id="total">$21</span></p>--}}

        <!--Campaigns-->
        <div class="form-group row campaign" id="cName{{$profile_id}}">
            <div class="col-md-2 d-flex">
                <div>
                    <label for="campaign" class="col-form-label">Campaigns</label>
                </div>
                <div class="ml-1 mt-1 mt-sm-2">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text">
                            A campaign is a simple way to organise your promoted listings into a single group, and allows you to track performance and manage all of your listings at the same time on your
                        </span>
                        <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <!-- <div class="col-md-12">
                    <input type=number step=0.1 name="bid_rate" max="100" value="1.0" />
                </div> -->
                <ul class="nav nav-tabs profile-tab" role="tablist" id="campTablist">
                    <li class="nav-item text-center campaignContent_{{$profile_id}}">
                        <a class="nav-link active" data-toggle="tab" href="#ebay_camp{{$profile_id}}">({{\App\EbayProfile::find($profile_id)->profile_name}})<span id="default_counter{{$profile_id}}"></span></a>
                    </li>
                </ul>
                <div class="container-fluid tab-content tab-content ebay-tab-content" id="campaign">
                    <div id="ebay_camp{{$profile_id}}" class="tab-pane active campaignContent_{{$profile_id}}">
                        <div class="card px-3 py-3">
                            <div class="d-flex">
                                <div class="custom-control custom-checkbox">
                                    <input name="campaign_checkbox[{{$profile_id}}]" type="checkbox" class="custom-control-input campaign_checkbox"  id="campaign_checkbox{{$profile_id}}">
                                    <label class="custom-control-label" onclick="campaignChecked(this)" id="{{$profile_id}}" for="campaign_checkbox"> </label>
                                </div>
                                <div>
                                    <p class="font-16">Boost your item's visibility with premium placements on eBay and pay only if your item sells.<a href="#" class="ml-1 text-decoration">Learn more</a></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <div>
                                    <p class="font-16 mr-2">Set ad rate</p>
                                </div>
                                <div id="wms-tooltip">
                                    <span id="wms-tooltip-text">
                                        Ad rate is the percentage of your final sale price that you’ll pay if your item sells via promoted listings within 30 days of a click on your ad. <b>Suggested ad rates</b> are tailored to each of your listings and designed to help you find the balance between cost and performance.
                                    </span>
                                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                                </div>
                                {{-- <div>
                                    <a data-toggle="tooltip" data-placement="top" title="Set Ad Rate">
                                        <img style="width: 25px; height: 25px;" src="{{asset('assets/common-assets/tooltip_button.png')}}">
                                    </a>
                                </div> --}}
                            </div>
                            <div class="row content_disabled" id="div_disable{{$profile_id}}">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="{{$profile_id}}">
                                            <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset('assets/common-assets/MINUS.png')}}" class="minus mb-1">
                                            <input type="text" size="3" name="bid_rate[{{$profile_id}}]" class="qty items_number" value="0.0"> %
                                            <img style="cursor: pointer; width: 30px; height: 30px" src="{{asset('assets/common-assets/PLUS.png')}}" class="plus mb-1">
                                        </p>
                                    </div>

                                    {{--                    <p class="mt-3 mb-3"><a href="#" class="text-decoration">Suggested ad rate 8.3%</a></p>--}}
                                    @if(isset($campaigns))
                                        <select name="campaign_id[{{$profile_id}}]" class="form-control select2 mt-2">
                                            @foreach($campaigns->campaigns as $campaign)
                                                @if($campaign->campaignName == 'Default campaign')
                                                    <option value="{{$campaign->campaignId}}" data-campaign="" selected>{{$campaign->campaignName}}</option>
                                                @else
                                                    <option value="{{$campaign->campaignId}}" data-campaign="">{{$campaign->campaignName}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <div class="vl"></div>
                                </div>
                                <div class="col-md-7">
                                    <p><b><span id="display_max_min_percentage{{$profile_id}}">£0.00 - £0.00</span></b></p>
                                    <p>(<span id="display_max_min_vat_percentage{{$profile_id}}">£0.00 - £0.00</span> inclusive of VAT, if applicable)</p>
                                    <p>Ad fee if this item sells through promoted listings</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    <!-- <div class="form-group row">
        <label for="Category" class="col-md-2 col-form-label required">Campaigns</label>
        <div class="col-md-10">

            <div class="col-md-12">
                {{--                                                        <h5></h5><span>(Write your value after the already inserted id and don't give '/' slash in your input value)</span><br>--}}
            </div>

            <div class="form-group">
                <div class="row d-flex justify-content-between">
                    @if(isset($campaigns))
                        <div class="col-md-4 mb-3">
                            <select name='campaign_id' class="form-control select2">

                                @foreach($campaigns->campaigns as $campaign)
                                    <option value="{{$campaign->campaignId}}" data-campaign="">{{$campaign->campaignName}}</option>
                                @endforeach

                            </select>
                        </div>
                    @endif
                </div>
            </div>



        </div>


    </div> -->



    <!--Total Fee-->
    <div id="profileName">
        <div class="form-group row" >
            <div class="col-md-2 d-flex">
                <div>
                    <label for="image_attribute" class="col-form-label">Fee</label>
                </div>
                <div class="ml-1">
                    <div id="wms-tooltip">
                        <span id="wms-tooltip-text" class="create-fee-text">
                            Click on the amount to see a breakdown of your fees.
                        </span>
                        <span><img class="wms-tooltip-image mt-2" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <ul class="nav nav-tabs profile-tab" role="tablist" id="feeTablist">
                    <li class="nav-item text-center feeContent_{{$profile_id}}">
                        <a class="nav-link active" data-toggle="tab" href="#totalFee{{$profile_id}}">{{\App\EbayProfile::find($profile_id)->profile_name}}</a>
                    </li>
                </ul>
                <div class="container-fluid tab-content tab-content ebay-tab-content" id="profile_total">
                    <div id="totalFee{{$profile_id}}" class="tab-pane active feeContent_{{$profile_id}}">
                        <div id="pName{{$profile_id}}" class="col-md-10 d-flex align-items-center" id="profileName">
                            <div class="mt-3 mb-3"><strong>Check Verify</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row" >
        <div class="col-md-2 d-flex align-items-center">
            <div>
                <label for="image_attribute" class="col-form-label">Total Fee</label>
            </div>
            <div class="ml-1">
                <div id="wms-tooltip">
                    <span id="wms-tooltip-text">
                        Click on the amount to see a breakdown of your fees.
                    </span>
                    <span><img class="wms-tooltip-image" src="{{asset('assets/common-assets/tooltip_button.png')}}"></span>
                </div>
            </div>
        </div>
        <div id="totalFees" class="col-md-10 d-flex align-items-center">
            <div><strong>Check Verify</strong></div>
        </div>
    </div>
    <div class="form-group row vendor-btn-top">
        <div class="col-md-12 text-center">
            <span class="draft-pro-btn btn btn-primary waves-effect waves-light" onclick="verify(1)">
                <b> Verify </b>
            </span>
            <button class="draft-pro-btn btn btn-primary waves-effect waves-light ml-2" type="submit">
                <b> Add </b>
            </button>
        </div>
{{--        <div class="col-md-12 text-center">--}}
{{--            --}}
{{--        </div>--}}
    </div>


<!-- end row -->
{{--</div> <!-- container -->--}}
{{--</div> <!-- content -->--}}
{{--</div>  <!-- content page -->--}}




<!----- ckeditor summernote ------->

<script type="text/javascript">

    var descriptionNum = $('div.description-tab').attr('id').replace(/[^0-9.]/gi, '')
    console.log('get des '+descriptionNum)
    // $('#messageArea'+descriptionNum).ckeditor();
    //     for (var i in CKEDITOR.instances) {
    //         CKEDITOR.instances[i].on('change', function() {
    //             document.getElementById('description_flag'+descriptionNum).value = 0;
    //             document.getElementById('description_flag'+descriptionNum).checked = false;
    //     });
    // }

    // CKEDITOR.instances['messageArea'+descriptionNum].on('change', function(e) {
    //     if (e.editor.checkDirty()) {
    //         var emailValChanged=true; // The action that you would like to call onChange
    //     }
    // });


    var counter_title_flag = 0;
    var counter_description_flag = 0;
    var counter_image_flag = 0;
    var switch_array = [];
    function Count(id,display) {
        //console.log($id,$display);
        var i = document.getElementById(id).value.length;
        document.getElementById(display).innerHTML = 'Character Remain: '+ (80 - i);
    }

    function onOff(id){
        // console.log(document.getElementById($id).value);
        var value_clicked = $('#'+id).val();

        if(value_clicked == 1){
            document.getElementById(id).value = 0;
            document.getElementById(id).checked = false;
        }
        else{
            document.getElementById(id).value = 1;
            document.getElementById(id).checked = true;
        }
        // console.log(document.getElementById($id).value);
        // imgDragDrop(id)
    }


        function feederQuantity(id){
            // console.log(id)
            var feederQty = document.getElementById('custom_feeder_quantity'+id).value;
            // console.log(feederQty)
            if(feederQty <= 0){
                document.getElementById('custom_feeder_flag'+id).value = 0;
                document.getElementById('custom_feeder_flag'+id).checked = false;
            }else{
                document.getElementById('custom_feeder_flag'+id).value = 1;
                document.getElementById('custom_feeder_flag'+id).checked = true;
            }
        }


        $(function() {
            $(".creat-ebay-product .ebay-image-wrap").sortable({
                    revert: true,
                    update: function() {
                    var id = $(this).closest('div').attr('id').split('_')[1]
                    console.log(id)
                    $('input#image_flag'+id).prop('checked', false)
                    document.getElementById('image_flag'+id).value = 0;
                }
            });
            $( ".creat-ebay-product .ebay-image-wrap" ).disableSelection();
        });


       // Condition if option New with tags selected
       $(document).ready(function(){
            var selectChangedFunc = function() {
                if ($('#condition-select').val() == '1000/New with tags') {
                    $('#condition-description-sec').hide();
                } else {
                    $('#condition-description-sec').show();
                }
            };

            selectChangedFunc();

            $('#condition-select').change(function() {
                selectChangedFunc();
            });

            $('.ebay-description-header').click()

        });


    function autoOff(id,profile_id){
    // console.log(switch_array.indexOf(id))
    // console.log(id)
        if (switch_array.indexOf(id) == '-1'){
            document.getElementById(id).checked = false;
            document.getElementById(id).value = 0;
            switch_array.push(id);
        }
        // if ($id == 'title_flag' && counter_title_flag == 0){
        //     document.getElementById($id).checked = false;
        //     document.getElementById($id).value = 0;
        //     counter_title_flag++;
        // }else if($id == 'description_flag' && counter_description_flag == 0){
        //     document.getElementById($id).checked = false;
        //     document.getElementById($id).value = 0;
        //     counter_description_flag++;
        // }else if($id == 'image_flag' && counter_image_flag == 0){
        //     document.getElementById($id).checked = false;
        //     document.getElementById($id).value = 0;
        //     counter_image_flag++;
        // }
        //  $('#'+id).one(function() {
        //     // alert('You will only see this once.');
        //         document.getElementById(id).checked = false;
        //         document.getElementById(id).value = 0;
        //  });

    }


   // Collapse Variation Expand Variation
    $(".header").click(function () {
        $header = $(this);
        $content = $header.next();
        $content.slideToggle(500, function () {
            $header.text(function () {
                return $content.is(":visible") ? "Collapse Variation" : "Expand Variation";
            });
        });
        $(this).toggleClass('primary-color text-white');
    });


    // Collapse Description Expand Description
    $('.ebay-description-header').click(function(){
        $header = $(this);
        $content = $header.next();
        $content.slideToggle(500, function(){
            $header.text(function(){
                return $content.is(":visible") ? "Collapse Description" : "Expand Description";
            })
        })
        $(this).toggleClass('primary-color text-white');
    })




    // Item increment decrement input
    $(function () {
        var prices = [];
        // console.log(prices);
        $('input.variation-start-price').each(function(){
            var getPrice = $(this).val().match(/[^£]*$/);
            prices.push(getPrice);
        })
        var max = Math.max.apply(Math, prices);
        var min = Math.min.apply(Math, prices);
        // console.log('This is max price ' + max);
        // console.log('This is min price ' + min);
        $(document).on("click", ".plus", function(){
            var qty = $(this).closest('p').find('.qty');
            var profileId = $(this).closest('p').attr('class');
            // console.log('1st profileID '+profileId)
            var currentVal = parseFloat($(qty).val());
            if (!isNaN(currentVal) && currentVal < 100) {
                $(qty).val((currentVal + 0.1).toFixed(1));
                var after_click_actual_value = currentVal + 0.1;
                // console.log('OnClickinput' + after_click_actual_value);
                var max_sum = (after_click_actual_value*max)/100 + parseFloat(max);
                var min_sum = (after_click_actual_value*min)/100 + parseFloat(min);
                // console.log('This is onclick max_sum ' + max_sum.toFixed(2));
                // console.log('This is onclick min_sum ' + min_sum.toFixed(2));
                var hsum = max_sum - max;
                var lsum = min_sum - min;
                // console.log('Total hsum' + hsum.toFixed(2));
                // console.log('Total lsum' + lsum.toFixed(2));
                $("#display_max_min_percentage"+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
            }
            if(currentVal >= 100){
               Swal.fire('Oops..','Do not type more than 100','warning')
                return false
            }
        });
        $(document).on("click", ".plus", function(){
            var qty = $(this).closest('p').find('.qty');
            var profileId = $(this).closest('p').attr('class');
            // console.log('1st profileID '+profileId)
            var currentVal = parseFloat($(qty).val());
            if (!isNaN(currentVal) && currentVal > 0) {
                $(qty).val((currentVal - 0.1).toFixed(1));
                var after_click_actual_value = currentVal - 0.1;
                // console.log('OnClickinput' + after_click_actual_value);
                var max_sum = (after_click_actual_value*max)/100 + parseFloat(max);
                var min_sum = (after_click_actual_value*min)/100 + parseFloat(min);
                // console.log('This is onclick max_sum ' + max_sum.toFixed(2));
                // console.log('This is onclick min_sum ' + min_sum.toFixed(2));
                var hsum = max_sum - max;
                var lsum = min_sum - min;
                // console.log('Total hsum' + hsum.toFixed(2));
                // console.log('Total lsum' + lsum.toFixed(2));
                $('#display_max_min_percentage'+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
                $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
            }
            if(currentVal <= 0){
                Swal.fire('Oops..','Do not type less than 0','warning')
                return false
            }
        });
    });


    // Campaign auto price show
    var prices = []
    // console.log(prices);
    $('input.variation-start-price').each(function(){
        var getPrice = $(this).val().match(/[^£]*$/);
        prices.push(getPrice);
    })
    var max = Math.max.apply(Math, prices);
    var min = Math.min.apply(Math, prices);
    // console.log('This is max price ' + max);
    // console.log('This is min price ' + min);

    $('input.items_number').keyup(function(){
        var profileId = $(this).closest('p').attr('class')
        // console.log('1st profileID '+profileId)
        var on_input_value = $(this).closest('p').find('input.items_number').val();
        // console.log('type value', on_input_value)
        // console.log('Oninput' + on_input_value);
        var max_sum = (on_input_value*max)/100 + parseFloat(max);
        var min_sum = (on_input_value*min)/100 + parseFloat(min);
        // console.log('This is max_sum ' + max_sum.toFixed(2));
        // console.log('This is min_sum ' + min_sum.toFixed(2));
        var hsum = max_sum - max;
        var lsum = min_sum - min;
        // console.log('Total hsum' + hsum.toFixed(2));
        // console.log('Total lsum' + lsum.toFixed(2));
        $('#display_max_min_percentage'+profileId).text('£'+ lsum.toFixed(2) + ' - ' + '£' + hsum.toFixed(2));
        $('#display_max_min_vat_percentage'+profileId).text('£'+ (((lsum*20)/100)+lsum).toFixed(2) + ' - ' + '£' + (((hsum*20)/100)+hsum).toFixed(2));
    });


     // Campaign Div content disable enable
     $(document).ready(function(){
        // $(".campaign_checkbox").click(function(){
        //     if($(this).is(":checked")){
        //         $("#div_disable").removeClass("content_disabled").addClass("remove_content_disabled");
        //     }else{
        //         $("#div_disable").removeClass("remove_content_disabled").addClass("content_disabled");
        //     }
        // });

    });
    function campaignChecked(e){

        if($("#campaign_checkbox"+e.id).is(":checked")){
            document.getElementById("campaign_checkbox"+e.id).checked = false;
            $("#div_disable"+e.id).removeClass("remove_content_disabled").addClass("content_disabled");
        }else{
            document.getElementById("campaign_checkbox"+e.id).checked = true;
            $("#div_disable"+e.id).removeClass("content_disabled").addClass("remove_content_disabled");

        }
    }


    //12 variation Drag drop image
       //Click to enlarge image modal preview
       $(function () {
            $('.md-trigger').on('click', function() {
                $('.md-modal').addClass('md-show');
            });
            $('.md-close').on('click', function() {
                $('.md-modal').removeClass('md-show');
            });
        });

        // Modal inside image counter
        // var imgProId = $('span#profileIdIndicate').attr('class');
        var imgProId = $('.form-group').closest('span').attr('class');
        // console.log('This is image profile ID ' + imgProId);
        var imageList = $('li#drag-drop-image'+imgProId).length;
        // console.log('This is image list ' + imageList);

        $('#uploadImage'+imgProId).first().closest('div').removeClass('no-img-content');
        $('#uploadImage'+imgProId).first().removeAttr('disabled');
        // $('p.inner-add-sign:first').css('opacity', '100');
        $('#innerAddSign'+imgProId).first().css('opacity', '100');
        // $('p.inner-add-photo:first').css('opacity', '100');
        $('#innerAddPhoto'+imgProId).first().css('opacity', '100');

        $('div#addPhotosContent'+imgProId).first().on('click', function(){
            if($(this).is(':first-child')) {
                // $('#btn-text'+imgProId).closest('div').find('input').remove();
                $('#btn-text'+imgProId).closest('div').find('input').removeAttr('id');
            }
        })

        $('div.addPhotoBtnDiv').on('click', function(){
            $('#btn-text'+imgProId).closest('div').find('input').attr('id','uploadImage'+imgProId);
        })

        var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
            '<div class="img-content-wrap">'+
                '<div class="addPhotoBtnDiv">'+
                    '<p class="btn-text">Add photos</p>'+
                    '<input type="file" title=" " name="uploadImage[]" id="uploadImage" class="form-control" accept="/image" onchange="preview_image();" multiple>'+
                '</div>'+
                '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
            '</div>'+
        '</div>');
        if(imageList == 0){
            $('#counter'+imgProId).text('We recommend adding 3 more photos');
            $('#showimagediv'+imgProId).html(notexistfirstDefaultImage).show();
            $('.md-trigger, .prev, .next').hide();
            $('.main_image_show').hover(function(){
                $('.md-trigger, .prev, .next').hide();
            });
        }else{
            // var firstDefaultImageSrc = $('li #drag_drop_image'+imgProId).attr('src');
            // var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            // $('#showimagediv'+imgProId).html(firstDefaultImage).show();
            var firstDefaultImageSrc = $('li .create_drag_drop_image:first').attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            $('.showimagediv').html(firstDefaultImage).show();
        }

        if(imageList == 1){
            $('#counter'+imgProId).text('We recommend adding 2 more photos');
        }else if(imageList == 2){
            $('#counter'+imgProId).text('We recommend adding 1 more photo');
        }else if(imageList == 3){
            $('#counter'+imgProId).text('Add up to 9 more photos');
        }else if(imageList == 4){
            $('#counter'+imgProId).text('Add up to 8 more photos');
        }else if(imageList == 5){
            $('#counter'+imgProId).text('Add up to 7 more photos');
        }else if(imageList == 6){
            $('#counter'+imgProId).text('Add up to 6 more photos');
        }else if(imageList == 7){
            $('#counter'+imgProId).text('Add up to 5 more photos');
        }else if(imageList == 8){
            $('#counter'+imgProId).text('Add up to 4 more photos');
        }else if(imageList == 9){
            $('#counter'+imgProId).text('Add up to 3 more photos');
        }else if(imageList == 10){
            $('#counter'+imgProId).text('Add up to 2 more photos');
        }else if(imageList == 11){
            $('#counter'+imgProId).text('Add up to 1 more photo');
        }
        else if(imageList == 12){
            $('#counter'+imgProId).text('Photo limit reached');
        }
        $('#default_counter'+imgProId).text(' (' + imageList + ')');
        $('#modal_counter'+imgProId).text(imageList + (imageList === 1 ? ' image':' images'));

        // Set starting index.
        // var index = imageList.index($('.active'));
        // $('#counter').text((index + 1) + ' of ' + imageList.length);
        // console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        // $('.after').on('click', function () {
        //     var currentImg = $('.active');
        //     var nextImg = currentImg.next();
        //     if (nextImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         nextImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(nextImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //         console.log($('#counter').text((index + 1) + ' of ' + imageList.length));
        //     }
        // });

        // $('.before').on('click', function () {
        //     var currentImg = $('.active');
        //     var prevImg = currentImg.prev();
        //     if (prevImg.length) {
        //         currentImg.removeClass('active').css('z-index', -10);
        //         prevImg.addClass('active').css('z-index', 10);
        //         // Find the index of the image.
        //         var index = imageList.index(prevImg);
        //         $('#counter').text((index + 1) + ' of ' + imageList.length);
        //     }
        // });

        //Small image on text show

        $(".create_drag_drop_image").hover(function () {
            $(this).next().removeClass('hide');
        }, function () {
            $(this).next().addClass('hide');
        });


        // $(".creat-ebay-product").hover('.create_drag_drop_image',function () {
        //         $(this).next().removeClass('hide');
        //     }, function () {
        //         $(this).next().addClass('hide');
        //    });


        //Next and Prev button show on Big image
        $(document).ready(function(){
            $('.main_image_show').hover(function(){
            $('.prev, .next, .md-trigger').removeClass('hide');
            },  function () {
                $('.prev, .next, .md-trigger').addClass('hide');
            });
        })

        //If keep cursor on next and previous button then click to enlarge button will disappear
        $(document).ready(function(){
            $('.prev, .next').hover(function(){
            $('.md-trigger').addClass('hide');
            }, function(){
                $('.md-trigger').removeClass('hide');
            });
        })

        // By default first image show left side image content
        // var firstDefaultImageSrc = $('li .create_drag_drop_image:first').attr('src');
        // var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
        // $('.showimagediv').html(firstDefaultImage).show();

        $('.creat-ebay-product').on('click','.create_drag_drop_image', function(){
            var id = $(this).closest('div').attr('id').split('_')[1]
            // console.log( "This is dy " +id)
            $('.create_drag_drop_image').removeClass('clicked')
            $(this).addClass('clicked')
            var img = $('<img />', {src : this.src,'class': 'fullImage'})
            $('#showimagediv'+id).html(img).show()
        });

        $(document).on('click','.next,.then',function(){
            if(!$(".clicked").is(".create_drag_drop_image:last")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $next, $selected = $(".clicked");
                $next = $selected.next('li.drag-drop-image').length ? $selected.next('li.drag-drop-image') : $first;

                $selected.removeClass("clicked");
                $next.addClass('clicked');

                var imgSrc = $next.find('img').attr('src');
                var img = $next.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($next.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });

        $(document).on('click','.prev,.previous',function(){
            if(!$(".clicked").is(".create_drag_drop_image:first")){
                var $first = $('li.drag-drop-image:first', 'ul.ebay-image-wrap'),
                $last = $('li.drag-drop-image:last', 'ul.ebay-image-wrap');
                var $prev, $selected = $(".clicked");

                $prev = $selected.prev('li.drag-drop-image').length ? $selected.prev('li.drag-drop-image') : $last;
                $selected.removeClass("clicked");
                $prev.addClass('clicked');

                var imgSrc = $prev.find('img').attr('src');
                var img = $prev.find('img');
                var img = $('<img />', {src : imgSrc,'class': 'fullImage'});
                console.log($prev.find('img').attr('src'));
                $('.showimagediv').html(img).show();
            }
        });


        // $(document).ready(function(){
            // $('.create-ebay-img-upload:first').parent('div').removeClass('no-img-content');
            $('li.drag-drop-image img:first').addClass('clicked');
            $('li.drag-drop-image p').text('Drag to rearrange');
            // $('li.drag-drop-image span.main_photo:first').text('Main Photo');
            //$('li.drag-drop-image span.main_photo:gt(0)').hide();
            // var imgList = $('li.drag-drop-image').length;
            // console.log(imgList + ' Image list');
            //By default remove attribute disabled
            // var firstRemoveAttribute = $('.add-photos-content input:first').attr('disabled');
            // $('.add-photos-content input:first').removeAttr(firstRemoveAttribute);
            // $('.add-photos-content .inner-add-sign:first,input:first,.inner-add-photo:first').css('opacity', '100');

            var imgProId = $('.cross-icon').closest('div').attr('id').split('_')[1];
            // console.log('dynamic split  '+ imgProId);
            $('#uploadImage'+imgProId).first().closest('div').removeClass('no-img-content');
            console.log($('#uploadImage'+imgProId).parent('div').removeClass('no-img-content'))
            $('#uploadImage'+imgProId).first().removeAttr('disabled');
            $('#innerAddSign'+imgProId).first().css('opacity', '100');
            $('#innerAddPhoto'+imgProId).first().css('opacity', '100');
            $('#uploadImage'+imgProId).first().css('opacity', '100');
        // })



        // Remove image list
        function removeLi(elem){
            var imgProId = $(elem).closest('div').attr('id').split('_')[1];
            // console.log('This is image pro append id '+ imgProId);
            $(elem).closest('li').remove();
            // console.log($(elem).closest('li').remove());
            $("#sortableImageDiv"+imgProId).last().append('<div class="drag-drop-image add-photos-content no-img-content" id="addPhotosContent'+imgProId+'">'+
                '<p class="inner-add-sign" id="innerAddSign'+imgProId+'">&#43;</p>'+
                '<input type="file" title=" " name="uploadImage['+imgProId+'][]" id="uploadImage'+imgProId+'" class="form-control create-ebay-img-upload" accept="/image" onchange="preview_image('+imgProId+');" multiple disabled>'+
                '<p class="inner-add-photo" id="innerAddPhoto'+imgProId+'">Add Photos</p>'+
            '</div>');
            // $('.add-photos-content input:first').removeAttr('disabled');

            $('#uploadImage'+imgProId).first().removeAttr('disabled');
            // $('p.inner-add-sign:first').css('opacity', '100');
            $('#innerAddSign'+imgProId).first().css('opacity', '100');
            // $('p.inner-add-photo:first').css('opacity', '100');
            $('#innerAddPhoto'+imgProId).first().css('opacity', '100');

            $('li.drag-drop-image img:first').addClass('clicked');
            $('li.drag-drop-image p').text('Drag to rearrange');
            // $('li.drag-drop-image span.main_photo:first').text('Main Photo');

            // var lftImgProId = $('.showimagediv').closest('div').attr('id').split('_')[1];
            var firstDefaultImageSrc = $('li #drag_drop_image'+imgProId).first().attr('src');
            var firstDefaultImage = $('<img />', {src : firstDefaultImageSrc,'class': 'fullImage'});
            var notexistfirstDefaultImage = $('<div class="img-upload-main-content">'+
                    '<div class="img-content-wrap">'+
                        '<div class="addPhotoBtnDiv">'+
                            '<p class="btn-text" id="btn-text'+imgProId+'">Add photos</p>'+
                            '<input type="file" title=" " name="uploadImage['+imgProId+'][]" id="uploadImage'+imgProId+'" class="form-control" accept="/image" onchange="preview_image('+imgProId+');" multiple>'+
                        '</div>'+
                        '<p class="photo-req-txt">Add up to 12 photos. We do not allow photos with extra borders, text or artwork.</p>'+
                    '</div>'+
                '</div>');

            if(firstDefaultImageSrc == null){
                $('#showimagediv'+imgProId).html(notexistfirstDefaultImage).show();
                $('.md-trigger, .prev, .next').hide();
                $('.main_image_show').hover(function(){
                    $('.md-trigger, .prev, .next').hide();
                });
            }else{
                $('#showimagediv'+imgProId).html(firstDefaultImage).show();
            }

            $('div#addPhotosContent'+imgProId).first().on('click', function(){
                if($(this).is(':first-child')) {
                    // $('#btn-text'+imgProId).closest('div').find('input').remove();
                    $('#btn-text'+imgProId).closest('div').find('input').removeAttr('id');
                }
            })

            $('div.addPhotoBtnDiv').on('click', function(){
                $('#btn-text'+imgProId).closest('div').find('input').attr('id','uploadImage'+imgProId);
            })

            $('#uploadImage'+imgProId).first().closest('div').removeClass('no-img-content');

            // $(function(){
            //     $('div.drag-drop-image:first').on("click", function () {
            //         $('.addPhotoBtnDiv input').addClass('hide');
            //         setTimeout(RemoveClass, 25000);
            //     });
            //     function RemoveClass() {
            //         $('.addPhotoBtnDiv input').RemoveClass('hide');
            //     }
            // });

            // var imgProId = $('.form-group').closest('span').attr('class');
            var imageList = $('li#drag-drop-image'+imgProId).length;
            if(imageList == 0){
                $('#counter'+imgProId).text('We recommend adding 3 more photos');
            }else if(imageList == 1){
                $('#counter'+imgProId).text('We recommend adding 2 more photos');
            }else if(imageList == 2){
                $('#counter'+imgProId).text('We recommend adding 1 more photo');
            }else if(imageList == 3){
                $('#counter'+imgProId).text('Add up to 9 more photos');}else if(imageList == 4){$('#counter'+imgProId).text('Add up to 8 more photos');}else if(imageList == 5){$('#counter'+imgProId).text('Add up to 7 more photos');}else if(imageList == 6){$('#counter'+imgProId).text('Add up to 6 more photos');}else if(imageList == 7){$('#counter'+imgProId).text('Add up to 5 more photos');}else if(imageList == 8){$('#counter'+imgProId).text('Add up to 4 more photos');}else if(imageList == 9){$('#counter'+imgProId).text('Add up to 3 more photos');}else if(imageList == 10){$('#counter'+imgProId).text('Add up to 2 more photos');}else if(imageList == 11){$('#counter'+imgProId).text('Add up to 1 more photo');}
            else if(imageList == 12){
                $('#counter'+imgProId).text('Photo limit reached');
            }
            $('#default_counter'+imgProId).text(' (' + imageList + ')');
            $('#modal_counter'+imgProId).text(imageList + (imageList === 1 ? ' image':' images'));

            if(imageList == 1){
                $('.prev, .next, .previous, .then').hide();
            }

            var errorIcon = $('a.image_dimension').length;
            if(errorIcon == 0){
                $('button').attr('disabled', false);
            }

        }


        function preview_image(profileId){
            console.log('upload id'+profileId);
            var total_file=document.getElementById("uploadImage"+profileId).files.length;
            var file_name = document.getElementById("uploadImage"+profileId).files;
            var fileUpload = document.getElementById("uploadImage"+profileId);
            var imageList = $('li#drag-drop-image'+profileId).length;
            if(total_file+imageList >= 13){
                Swal.fire('Oops.. Photo limit exceeded','You have exceeded the total amount of photos allowed. Only the first 12 photos have been uploaded','warning');
            }
            var temp = '';
            for(var i=0;i<total_file;i++){
                var reader = new FileReader();
                var file = file_name[i];
                (function(file){
                    console.log(file);
                    reader.onload = function(event) {
                    var image = new Image();
                    image.src = event.target.result;
                    image.onload = function (i) {
                        var height = this.height;
                        var width = this.width;
                        var t = file.type;
                        var n = file.name;
                        var s = ~~(file.size/1024) +'KB';
                        var errorIcon = '';
                        if(height < 500){
                            errorIcon += '<a class="image_dimension" title="error"></a>'+
                            '<div class="image_dimension_error_show hide">'+
                                '<span><b>Photo quality issues :</b></span><br>'+
                                '<span>"Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option."</span>'+
                            '</div>'

                            $('button').on('click', function(){
                                var iconError = $('a.image_dimension').length;
                                if(iconError > 0){
                                    $(this).attr('disabled','disabled');
                                    Swal.fire('Oops.. Photo quality error issue!!','Upload high resolution photos that are at least 500 pixels on the longest side. If you are uploading a photo from your smartphone, select the medium or large photo size option. It looks like there is a problem with this listing.','warning');
                                }
                            });

                        }// if close height


                        $('<li class="drag-drop-image" id="drag-drop-image'+profileId+'">'+ // After uploading image
                                '<a class="cross-icon bg-white border-0 btn-outline-light" id="'+file.name+'" onclick="removeLi(this)">&#10060;</a>'+
                                '<input type="hidden" id="image" name="image['+profileId+'][]" value="'+file.name+'">'+
                                '<span class="main_photo"></span>'+
                                '<img class="create_drag_drop_image" id="drag_drop_image'+profileId+'" src="'+event.target.result+'"  alt="">'+
                                '<p class="drag_and_drop hide" id="drag_and_drop_'+profileId+'"></p>'+
                                errorIcon+
                                '<input type="hidden" name="newUploadImage['+profileId+']['+file.name+']" value="'+event.target.result+'">'+
                        '</li>').insertBefore("#addPhotosContent"+profileId).first();

                        $('a.image_dimension').hover(function(){ //each error button hover
                            $(this).next().removeClass('hide');
                        }, function(){
                            $(this).next().addClass('hide');
                        });

                        // $('div.add-photos-content:last').remove(); // Removing last div
                        $('div#addPhotosContent'+profileId).last().remove(); // Removing last div

                        // var imgProId = $('.form-group').closest('span').attr('class');
                        var imageList = $('li#drag-drop-image'+profileId).length;
                        // console.log('After uploading image = ' +imageList + ' images');
                        if(imageList == 0){
                            $('#counter'+profileId).text('We recommend adding 3 more photos');
                        }else if(imageList == 1){
                            $('#counter'+profileId).text('We recommend adding 2 more photos');
                        }else if(imageList == 2){
                            $('#counter'+profileId).text('We recommend adding 1 more photo');
                        }else if(imageList == 3){
                            $('#counter'+profileId).text('Add up to 9 more photos');
                        }else if(imageList == 4){
                            $('#counter'+profileId).text('Add up to 8 more photos');
                        }else if(imageList == 5){
                            $('#counter'+profileId).text('Add up to 7 more photos');
                        }else if(imageList == 6){
                            $('#counter'+profileId).text('Add up to 6 more photos');
                        }else if(imageList == 7){
                            $('#counter'+profileId).text('Add up to 5 more photos');
                        }else if(imageList == 8){
                            $('#counter'+profileId).text('Add up to 4 more photos');
                        }else if(imageList == 9){
                            $('#counter'+profileId).text('Add up to 3 more photos');
                        }else if(imageList == 10){
                            $('#counter'+profileId).text('Add up to 2 more photos');
                        }else if(imageList == 11){
                            $('#counter'+profileId).text('Add up to 1 more photo');
                        }else if(imageList == 12){
                            $('#counter'+profileId).text('Photo limit reached');
                        }
                        $('#default_counter'+profileId).text(' (' + imageList + ')');
                        $('#modal_counter'+profileId).text(imageList + (imageList === 1 ? ' image':' images'));

                        $('li.drag-drop-image p:last').text('Drag to rearrange');
                        // $('li.drag-drop-image span.main_photo:first').text('Main Photo');

                        $('img.create_drag_drop_image:last').addClass('clicked'); //By default last image active show

                        var $afterUploadLastImgView = $('img#drag_drop_image'+profileId).last().attr('src');
                        var $img = $('<img />', {src : $afterUploadLastImgView,'class': 'fullImage'});
                        $('#showimagediv'+profileId).html($img).show();

                        $('#drag_drop_image'+profileId).click(function(){
                            $('.create_drag_drop_image').removeClass('clicked');
                            $(this).addClass('clicked');
                            var img = $('<img />', {src : this.src,'class': 'fullImage'});
                            $('#showimagediv'+profileId).html(img).show();
                        });

                        $(".create_drag_drop_image").hover(function () {
                            $(this).next().removeClass('hide');
                        }, function () {
                            $(this).next().addClass('hide');
                        });

                        $('.prev, .next').hover(function(){
                            $('.md-trigger').addClass('hide');
                        }, function(){
                            $('.md-trigger').removeClass('hide');
                        });

                        $('.main_image_show').hover(function(){
                            $('.prev,.next,.md-trigger,.before,.after,.then,.previous').removeAttr('style');
                        });

                        $('div.ajax_counter:gt(0)').hide()

                    };



                } // function file close

                reader.readAsDataURL(file);
                })(file);

            } // for loop close

        } // preview_image close

        //End 12 variation Drag drop image



</script>
